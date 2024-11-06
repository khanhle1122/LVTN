<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert(
            
            [
                'name' => 'Lê Quốc Khánh',
                'email' => 'tes665454@example.com',
                'address' => 'Cần Thơ',
                'phone' => '0336343416',
                'usercode' => 'b2014751',
                'password' => Hash::make('111'),
                'role' => 'admin',
               
            ],
        
        
    );
    }
}
