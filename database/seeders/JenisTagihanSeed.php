<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JenisTagihan;
use Ramsey\Uuid\Uuid;

class JenisTagihanSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = JenisTagihan::where('Jenis','Syahriah')->first();
        if(!$check) {
            $jenis = new JenisTagihan;
            $jenis->Oid = Uuid::uuid4();
            $jenis->Jenis = 'Syahriah';
            $jenis->Jumlah = 100000;
            $jenis->save();
        }
    }
}
