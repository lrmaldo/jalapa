<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Team;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        DB::transaction(function ()  {
            return tap(User::create([
                'name' => 'admin',
                'email' =>'lrmaldo@gmail.com',
                'password' => Hash::make('admin'),
            ]), function (User $user) {
                $user->ownedTeams()->save(Team::forceCreate([
                  'user_id' => $user->id,
                  'name' => "Equipo RMS",
                  'personal_team' => true,
                ]));
            });
        });

        /* Herrera.120582@gmail.com */
        DB::transaction(function ()  {
            return tap(User::create([
                'name' => 'Jorge',
                'email' =>'herrera.120582@gmail.com',
                'password' => Hash::make('admin'),
            ]), function (User $user) {
                $user->ownedTeams()->save(Team::forceCreate([
                  'user_id' => $user->id,
                  'name' => "Equipo RMS",
                  'personal_team' => true,
                ]));
            });
        });

    }
}
