<?php
use App\Model\ActionStatusManagement\Status;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $statuses = json_decode(File::get('database/dump/status.json'));
        foreach($statuses as $status)
        {
            Status::create(array(
                "is_entry_point"=>isset($status->is_entry_point)?$status->is_entry_point:false,
                "type"=>$status->type,
                "key"=>$status->key,
                "name"=>$status->name,
                //lets say only 80%
                "info"=>rand(0,100)<80?$faker->paragraph(3):null
            ));
        }
    }
}
