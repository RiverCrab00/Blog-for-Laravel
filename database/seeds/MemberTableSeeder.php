<?php

use Illuminate\Database\Seeder;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker=\Faker\Factory::create('zh_CN');
        for($i=0;$i<5;$i++){
            \DB::table('member')->insert([
                'mem_name'=>$faker->name,
                'mem_pass'=>bcrypt('123456'),
                'mem_email'=>$faker->email,
                'mem_age'=>$faker->numberBetween($min = 20, $max = 90),
                'mem_phone'=>$faker->phoneNumber,
                'mem_sex'=>'男',
                'mem_pic'=>$faker->imageUrl(),
                'mem_desc'=>$faker->catchPhrase,
            ]);
        }
    }
}
