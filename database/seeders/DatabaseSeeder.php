<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
        ]);

        Company::create([
            'name' => 'Infinite Learning',
            'email' => 'infinitelearning@gmail.com',
            'address' => 'Jl. Hang Lekiu, Sambau, Kecamatan Nongsa, Kota Batam, Kepulauan Riau 29465',
            'latitude' => '1.185452756143005',
            'longitude' => '104.10199249556887',
            'radius_km' => '0.5',
            'time_in' => '08:00',
            'time_out' => '17:00',
        ]);

        $this->call([
            AttendanceSeeder::class,
        ]);
    }
}
