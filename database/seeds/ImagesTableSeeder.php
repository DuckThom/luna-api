<?php

use Illuminate\Database\Seeder;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Api\Models\User::all()->each(function ($user) {
            for ($i = 0; $i < 100; $i++) {
                $user->images()->save(factory(Api\Models\Image::class)->make());
            }
        });
    }
}
