<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RightSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleRightSeeder::class);
        $this->call(ProjectKindSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ProjectAssignmentSeeder::class);
        $this->call(ProjectViewSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(FolderRequestSeeder::class);
        $this->call(RequestSeeder::class);
        $this->call(FolderRequirementSeeder::class);
        $this->call(RequirementSeeder::class);
    }
}
