<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Project;
use App\Models\Timesheet;
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
        // User::factory(10)->create();

        // Create an admin user
        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        // Create additional users
        User::factory(10)->create();

        Attribute::factory(10)->create();

        // Create projects
        Project::factory(5)->create()->each(function ($project) {
            // Create timesheets for each project
            Timesheet::factory(3)->create([
                'project_id' => $project->id,
                'user_id' => User::inRandomOrder()->first()->id,
            ]);
            // Create attributes for each project
            $project->attributes()->attach(Attribute::inRandomOrder()->first()->id);
        });
    }
}
