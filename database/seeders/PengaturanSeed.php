<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengaturan;
use Ramsey\Uuid\Uuid;

class PengaturanSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pengaturan::truncate();
        
        $data = [
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Nama',
                'Isi' => 'LOREM'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Logo',
                'Isi' => 'assets/images/logo.png'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Alamat',
                'Isi' => 'Padas Kedungjati'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Telepon',
                'Isi' => '021 234 212'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Fax',
                'Isi' => '021 234 213'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Website',
                'Isi' => 'www.web.site'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Email',
                'Isi' => 'kontak@web.site'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Jenjang',
                'Isi' => 'PAUDQu'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'NoStatistik',
                'Isi' => '2352535234234'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'ThnBerdiriHijriah',
                'Isi' => '1443'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'ThnBerdiriMasehi',
                'Isi' => '2021'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'NoSK',
                'Isi' => '23/1SK-332'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'TglSK',
                'Isi' => '2021-02-04'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'PenerbitSK',
                'Isi' => 'kontak@web.site'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Topografi',
                'Isi' => 'Dataran Tinggi'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Geografi',
                'Isi' => 'Pegunungan'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'PotensiEkonomi',
                'Isi' => 'Perkebunan'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'NoStatistik',
                'Isi' => '253563647575868'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'RT',
                'Isi' => '04'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'RW',
                'Isi' => '10'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Provinsi',
                'Isi' => 'Jawa Tengah'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Kota',
                'Isi' => 'Grobogan'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Kecamatan',
                'Isi' => 'Kedungjati'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'KodePos',
                'Isi' => '56234'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Lintang',
                'Isi' => '23523.42'
            ],
            [
                'Oid' => Uuid::uuid4(),
                'Kode' => 'Bujur',
                'Isi' => '-12455.22'
            ],
        ];
        foreach($data as $row) Pengaturan::insert($row);
    }
}
