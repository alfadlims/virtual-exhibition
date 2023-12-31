<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Painting;
use Illuminate\Support\Str;
use App\Models\LikedPainting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LikedPaintingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paintings = Painting::all();
        $users = User::all();

        foreach ($users as $user) {
            LikedPainting::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'painting_id' => $paintings->random()->id,
            ]);

            LikedPainting::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'painting_id' => $paintings->random()->id,
            ]);
        }
    }
}
