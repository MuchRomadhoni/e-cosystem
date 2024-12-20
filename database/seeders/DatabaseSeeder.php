<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => "doni user",
            'email' => 'doniUser@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $this->call([
            UserSeeder::class,
            DivisiSeeder::class,
            JabatanSeeder::class,
            KantorSeeder::class,
            ShiftSeeder::class,
            // ScheduleSeeder::class
        ]);
    }
}
