<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        \DB::table('invoice_templates')->insert([
            [
                'header' => 'BPK PENABUR JAKARTA
Gedung Ukrida Blok E lt. 6
Jl. Tanjung Duren Raya No. 4
Jakarta Barat 11470',
                'name' => 'Novan Haryadi',
                'position' => 'Kadiv. Keuangan & Akunting BPK PENABUR Jakarta',
                'note' => '*Note: Bukti transfer harap diemail ke __anastasia.setiyowati@bpkpenaburjakarta.or.id__*',
                'company_id' => '4'
            ]
        ]);
    }
}
