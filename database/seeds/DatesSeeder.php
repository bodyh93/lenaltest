<?php

use Illuminate\Database\Seeder;

class DatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'del',
            'email' => 'd@d.d',
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'remember_token' => str_random(10),
        ]);
        factory(App\User::class, 5)
            ->create()
            ->each(function ($u) {
                $u->dates()->saveMany(factory(App\Date::class, rand(15, 50))->make());
            });
    }
}
