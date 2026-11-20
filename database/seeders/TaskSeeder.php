<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Task::factory()->create(['title' => 'Да прочета лекция 5', 'is_done' => true]);
        Task::factory()->create(['title' => 'Да създам MemberController', 'is_done' => false]);
        Task::factory()->create(['title' => 'Да напиша StoreMemberRequest', 'is_done' => false]);
    }
}
