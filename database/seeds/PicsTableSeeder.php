<?php

use Illuminate\Database\Seeder;

class PicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Pic::create(array(
            'filename' => '17993.png',
        ));

        \App\Pic::create(array(
            'filename' => '68496.jpg',
        ));

        \App\Pic::create(array(
            'filename' => '38592.jpg',
        ));

        \App\Pic::create(array(
            'filename' => '14154.jpg',
        ));
    }
}
