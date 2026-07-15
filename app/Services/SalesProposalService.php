<?php

// app/Services/SalesProposalService.php

namespace App\Services;

use App\Models\SalesProposal;
use App\Models\SellingPrice;
use App\Models\SellingPriceDetail;
use App\Models\TermOfPayment;
use Illuminate\Support\Facades\DB;

class SalesProposalService
{
     // ── Generate ID Proposal ─────────────────────────────────────────
     private function generateId(): string
     {
          $prefix     = 'SPR-' . now()->format('ymd') . '-';
          $lastNumber = SalesProposal::where('id_proposal', 'like', $prefix . '%')
               ->lockForUpdate()
               ->count();

          return $prefix . str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
     }

     // ── Hitung SSP & posisi harga per item ──────────────────────────
     private function resolveItemDetail(array $item): array
     {
          $sellingPrice = SellingPrice::where('id_selling_price', $item['selling_price_id'])
               ->where('item_id', $item['item_id'])
               ->where('status', 'approved')
               ->firstOrFail();

          $sspDetail = SellingPriceDetail::where('selling_price_id', $sellingPrice->id_selling_price)
               ->selectRaw('MIN(suggested_selling_price) as ssp_min, MAX(suggested_selling_price) as ssp_max')
               ->first();

          $proposedPrice = (float) $item['proposed_price'];
          $sspMin        = (float) ($sspDetail->ssp_min ?? 0);
          $sspMax        = (float) ($sspDetail->ssp_max ?? 0);

          if (! $sspMin || ! $sspMax) {
               throw new \RuntimeException(
                    "SSP untuk item {$item['item_id']} belum tersedia."
               );
          }

          // ── 1. Posisi harga ──────────────────────────────────────────────
          $pricePosition = match (true) {
               $proposedPrice > $sspMax               => 'above_max',
               $proposedPrice == $sspMax              => 'at_max',
               $proposedPrice >= $sspMin              => 'between',
               default                                => 'below_min',
          };

          // ── 2. Selisih berdasarkan posisi ────────────────────────────────
          [$priceDiff, $priceDiffPct] = match ($pricePosition) {
               'above_max' => [
                    $proposedPrice - $sspMax,
                    round((($proposedPrice - $sspMax) / $sspMax) * 100, 4),
               ],
               'below_min' => [
                    $proposedPrice - $sspMin,
                    round((($proposedPrice - $sspMin) / $sspMin) * 100, 4),
               ],
               // between & at_max → diff = 0
               default => [0, 0],
          };

          // ── 3. Flag below SSP — hanya true jika below_min ────────────────
          $isBelowSsp = ($pricePosition === 'below_min');

          return [
               'item_id'          => $item['item_id'],
               'selling_price_id' => $item['selling_price_id'],
               'qty'              => (float) $item['qty'],
               'ssp_min_snapshot' => $sspMin,
               'ssp_max_snapshot' => $sspMax,
               'proposed_price'   => $proposedPrice,
               'price_diff'       => $priceDiff,
               'price_diff_pct'   => $priceDiffPct,
               'price_position'   => $pricePosition,
               'is_below_ssp'     => $isBelowSsp,
               'created_at'       => now(),
               'updated_at'       => now(),
          ];
     }

     // ── Submit proposal ──────────────────────────────────────────────
     public function submit(array $data): array
     {
          return DB::transaction(function () use ($data) {
               $top = TermOfPayment::findOrFail($data['top_id']);

               $detailsPayload = array_map(
                    fn($item) => $this->resolveItemDetail($item),
                    $data['items']
               );

               // Pending hanya jika ada item dengan price_position = below_min
               $hasBelow = collect($detailsPayload)
                    ->contains('is_below_ssp', true);

               $proposal = SalesProposal::create([
                    'id_proposal'       => $this->generateId(),
                    'customer_id'       => $data['customer_id'],
                    'top_id'            => $top->id,
                    'top_days_snapshot' => $top->days,
                    'status'            => $hasBelow ? 'pending_approval' : 'approved',
                    'submitted_by'      => auth()->id(),
                    'submitted_at'      => now(),
               ]);

               $proposal->sales_proposal_details()->createMany($detailsPayload);

               return [
                    'proposal' => $proposal,
                    'hasBelow' => $hasBelow,
               ];
          });
     }

     public function update(SalesProposal $proposal, array $data): array
     {
          return DB::transaction(function () use ($proposal, $data) {
               $top = TermOfPayment::findOrFail($data['top_id']);

               // Proses ulang semua item
               $detailsPayload = array_map(
                    fn($item) => $this->resolveItemDetail($item),
                    $data['items']
               );

               $hasBelow = collect($detailsPayload)->contains('is_below_ssp', true);

               // Update header
               $proposal->update([
                    'customer_id'       => $data['customer_id'],
                    'top_id'            => $top->id,
                    'top_days_snapshot' => $top->days,
                    'status'            => $hasBelow ? 'pending_approval' : 'approved',
               ]);

               // Hapus detail lama, insert ulang
               $proposal->sales_proposal_details()->delete();
               $proposal->sales_proposal_details()->createMany($detailsPayload);

               return [
                    'proposal' => $proposal,
                    'hasBelow' => $hasBelow,
               ];
          });
     }
     
     /**
     * Manager approve pengajuan yang di bawah SSP.
     */
     public function approve(string $proposalId, int $reviewedBy): void
     {
          $proposal = SalesProposal::where('id_proposal', $proposalId)
               ->where('status', 'pending_approval')
               ->firstOrFail();

          $proposal->update([
               'status'      => 'manager_approved',
               'reviewed_by' => $reviewedBy,
               'reviewed_at' => now(),
          ]);
     }

    /**
     * Manager reject pengajuan yang di bawah SSP.
     */
     public function reject(string $proposalId, int $reviewedBy, string $note): void
     {
          $proposal = SalesProposal::where('id_proposal', $proposalId)
               ->where('status', 'pending_approval')
               ->firstOrFail();

          $proposal->update([
               'status'         => 'rejected',
               'reviewed_by'    => $reviewedBy,
               'reviewed_at'    => now(),
               'rejection_note' => $note,
          ]);
     }
}