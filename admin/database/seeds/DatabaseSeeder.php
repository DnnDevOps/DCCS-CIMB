<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(StatusTableSeeder::class);
        $this->call(DispositionTableSeeder::class);
        $this->call(AdminTableSeeder::class);
        $this->call(PermissionTableSeeder::class);

        Model::reguard();
    }
}
