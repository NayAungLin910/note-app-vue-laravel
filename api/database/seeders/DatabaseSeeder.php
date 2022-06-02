<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Label;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'email' => 'nal@gmail.com',
            'name' => 'Nay Aung Lin',
            'password' => Hash::make('password'),
            'image' => '/image/user.png',
        ]);

        Color::create([
            'name' => 'bg-dark',
        ]);
        Color::create([
            'name' => 'bg-danger',
        ]);
        Color::create([
            'name' => 'bg-success',
        ]);
        Color::create([
            'name' => 'bg-primary',
        ]);
        Color::create([
            'name' => 'bg-warning',
        ]);
        Color::create([
            'name' => 'bg-info',
        ]);

        Label::create([
            'user_id' => '1',
            'slug' => 'Tutorial',
            'name' => 'Tutorial'
        ]);
        Label::create([
            'user_id' => '1',
            'slug' => 'Development',
            'name' => 'Development'
        ]);
        Label::create([
            'user_id' => '1',
            'slug' => 'Marketing',
            'name' => 'Marketing'
        ]);
        Label::create([
            'user_id' => '3',
            'slug' => 'dancing-three',
            'name' => 'Dancing'
        ]);
    }
}
