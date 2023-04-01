<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $author = User::create([
            'name' => 'Author 1',
            'password' => Hash::make('author123'),
            'email' => 'author@example.net',
        ]);

        $author->assignRole('author');

        $author2 = User::create([
            'name' => 'Author 2',
            'password' => Hash::make('author123'),
            'email' => 'author2@example.net',
        ]);

        $author2->assignRole('author');


        $visitor = User::create([
            'name' => 'Visitor 1',
            'password' => Hash::make('visitor123'),
            'email' => 'visitor@example.net',
        ]);

        $visitor->assignRole('visitor');

    }
}
