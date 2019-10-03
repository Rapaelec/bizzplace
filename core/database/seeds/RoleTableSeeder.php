<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_vendeur = new Role();
        $role_vendeur->name = 'vendeur_bizzplace';
        $role_vendeur->description = 'Bizzplace en tant que vendeur';
        $role_vendeur->save();
    }
}
