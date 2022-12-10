<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengguna;
use Ramsey\Uuid\Uuid;

class PenggunaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $check = Pengguna::where('Username','admin')->first();
        if(!$check) {
            Pengguna::insert([
                'Oid' => Uuid::uuid4(),
                'Nama' => 'Administrator',
                'Username' => 'admin',
                'Password' => bcrypt('123'),
                'Role' => 'admin'
            ]);
        }
    }
}
