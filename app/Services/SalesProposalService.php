<?php

// app/Services/SalesProposalService.php

namespace App\Services;

use App\Models\SalesProposal;
use App\Models\SellingPrice;
use App\Models\SellingPriceDetail;
use Illuminate\Support\Facades\DB;

class SalesProposalService
{
     /**
          * Submit pengajuan harga oleh sales.
          * Auto approve jika proposed_price >= ssp_max.
          * Pending approval jika proposed_price < ssp_max.
          */
     public function submit(
          string $customerId,
          string $itemId,
          float  $proposedPrice,
          int    $submittedBy
          ): SalesProposal {

               // Ambil SSP approved terbaru untuk item ini
               $sellingPrice = SellingPrice::where('item_id', $itemId)
                    ->where('status', 'approved')
                    ->latest('approved_at')
                    ->firstOrFail();

               // Ambil SSP Min & Max dari details
               $sspMin = SellingPriceDetail::where('selling_price_id', $sellingPrice->id_selling_price)
                    ->min('suggested_selling_price');

               $sspMax = SellingPriceDetail::where('selling_price_id', $sellingPrice->id_selling_price)
                    ->max('suggested_selling_price');

               if (!$sspMin || !$sspMax) {
                    throw new \RuntimeException(
                         "SSP untuk item {$itemId} belum tersedia."
                    );
               }

               // 1. Tentukan posisi harga terlebih dahulu ────────────────────────────
               $pricePosition = match(true) {
                    $proposedPrice > $sspMax                  => 'above_max',
                    $proposedPrice == $sspMax                 => 'at_max',
                    $proposedPrice >= $sspMin                 => 'between', // di antara min & max (inklusif terhadap min)
                    default                                   => 'below_min',
               };

               // 2. Hitung selisih berdasarkan posisi harga (Kriteria Baru) ───────────
               switch ($pricePosition) {
                    case 'above_max':
                         $priceDiff    = $proposedPrice - $sspMax; // Plus terhitung dari Max
                         $priceDiffPct = ($priceDiff / $sspMax) * 100;
                         break;

                    case 'below_min':
                         $priceDiff    = $proposedPrice - $sspMin; // Minus terhitung dari Min
                         $priceDiffPct = ($priceDiff / $sspMin) * 100;
                         break;

                    case 'between':
                    case 'at_max': 
                    default:
                         // Jika antara min-max atau pas di max, buat null atau 0
                         $priceDiff    = 0; // atau null, sesuaikan dengan tipe data database Anda
                         $priceDiffPct = 0; // atau null
                         break;
               }

               // Tentukan flag status (Auto-approve jika masuk range aman: 'between', 'at_max', 'above_max')
               // Artinya, pending_approval HANYA jika harganya 'below_min'
               $isBelowSsp = ($pricePosition === 'below_min');

               // ── Generate ID ──────────────────────────────────────────────
               $now      = now();
               $sequence = str_pad(
                    SalesProposal::whereDate('created_at', today())->count() + 1,
                    3, '0', STR_PAD_LEFT
               );
               $proposalId = 'SPR-' . $now->format('ymd') . '-' . $sequence;

               return DB::transaction(function () use (
                    $proposalId, $customerId, $itemId, $sellingPrice,
                    $sspMin, $sspMax, $proposedPrice, $isBelowSsp,
                    $priceDiff, $priceDiffPct, $pricePosition,
                    $submittedBy, $now
               ) {
                    return SalesProposal::create([
                         'id_proposal'       => $proposalId,
                         'customer_id'       => $customerId,
                         'item_id'           => $itemId,
                         'selling_price_id'  => $sellingPrice->id_selling_price,

                         // Snapshot
                         'ssp_min_snapshot'  => $sspMin,
                         'ssp_max_snapshot'  => $sspMax,
                         'proposed_price'    => $proposedPrice,

                         // Selisih
                         'price_diff'        => $priceDiff,
                         'price_diff_pct'    => $priceDiffPct,

                         // Posisi harga
                         'price_position'    => $pricePosition,
                         'is_below_ssp'      => $isBelowSsp,

                         // Status — auto approve jika >= SSP Max
                         'status'            => $isBelowSsp ? 'pending_approval' : 'approved',

                         'submitted_by'      => $submittedBy,
                         'submitted_at'      => $now,
                    ]);
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