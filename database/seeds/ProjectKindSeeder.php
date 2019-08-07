<?php

use Illuminate\Database\Seeder;
use App\Model\ProjectManagement\ProjectKind;
use Faker\Factory as Faker;
class ProjectKindSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $kinds = json_decode(File::get('database/dump/project_kinds.json'));
        foreach($kinds as $kind)
        {
            ProjectKind::create(array(
                'name'=>$kind->name,
                'summary'=>$faker->sentence(10),
                //lets say that only around 80% of kind has description
                'description'=>rand(0,100)<80?$faker->paragraph(3):null
            ));
        }
    }
}
