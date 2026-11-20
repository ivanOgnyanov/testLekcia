<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::factory()->create([
            'name' => 'Петър Петров',
            'email' => 'petar@abv.bg',
        ]);

        Member::factory(5)->create();
    }
}
