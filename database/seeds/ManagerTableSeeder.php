<?php

use Illuminate\Database\Seeder;

class ManagerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=\Faker\Factory::create();
        for($i=0;$i<5;$i++){
            $date_time = $faker->date().''. $faker->time();
            \DB::table('manager')->insert([
                'username'=>$faker->name,
                'password'=>bcrypt(123456),
                'phone'=>$faker->phoneNumber,
                'email'=>$faker->email,
                'created_at' => $date_time,
                'updated_at' => $date_time,
            ]);
        }
    }
}
