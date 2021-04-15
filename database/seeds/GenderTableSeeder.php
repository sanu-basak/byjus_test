<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('genders')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $data =  [
            [
                'name'      => 'Male',
                'is_active' => 1
            ],
            [
                'name'      => 'Female',
                'is_active' => 1
            ],
            [
                'name'      => 'Other',
                'is_active' => 1
            ]
        ];

        \DB::table('genders')->insert($data);

    }
}
