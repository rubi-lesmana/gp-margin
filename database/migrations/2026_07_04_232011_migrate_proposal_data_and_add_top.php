<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // ── 1. Tambah kolom top_id & snapshot dulu (nullable sementara) ──────
        Schema::table('sales_proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('top_id')->nullable()->after('customer_id');
            $table->foreign('top_id')->references('id')->on('term_of_payments');
            $table->unsignedSmallInteger('top_days_snapshot')->nullable()->after('top_id');
        });

        // ── 2. Pindah data dari header → detail ──────────────────────────────
        $proposals = DB::table('sales_proposals')
            ->whereNotNull('item_id')           // kolom lama masih ada
            ->get();

        foreach ($proposals as $p) {
            DB::table('sales_proposal_details')->insertOrIgnore([
                'proposal_id'       => $p->id_proposal,
                'item_id'           => $p->item_id,
                'selling_price_id'  => $p->selling_price_id,
                'qty'               => 1,       // default — data lama tidak punya qty
                'ssp_min_snapshot'  => $p->ssp_min_snapshot,
                'ssp_max_snapshot'  => $p->ssp_max_snapshot,
                'proposed_price'    => $p->proposed_price,
                'price_diff'        => $p->price_diff,
                'price_diff_pct'    => $p->price_diff_pct,
                'price_position'    => $p->price_position,
                'is_below_ssp'      => $p->is_below_ssp,
                'created_at'        => $p->created_at,
                'updated_at'        => $p->updated_at,
            ]);
        }

        // ── 3. Set top_id default jika ada TOP yang berlaku umum ─────────────
        // Sesuaikan logic ini dengan bisnis — contoh: ambil TOP terpendek
        $defaultTop = DB::table('term_of_payments')->orderBy('days')->first();
        if ($defaultTop) {
            DB::table('sales_proposals')
                ->whereNull('top_id')
                ->update([
                    'top_id'           => $defaultTop->id,
                    'top_days_snapshot'=> $defaultTop->days,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Kembalikan kolom top jika rollback
        Schema::table('sales_proposals', function (Blueprint $table) {
            $table->dropForeign(['top_id']);
            $table->dropColumn(['top_id', 'top_days_snapshot']);
        });

        // Hapus data detail yang sudah dipindah
        DB::table('sales_proposal_details')->truncate();
    }
};