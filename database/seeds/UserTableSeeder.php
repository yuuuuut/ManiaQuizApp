<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class)->create()->each(function ($user) {
            factory(App\Models\Performance::class)->create(['user_id' => $user->id ]);
        });
    }
}
