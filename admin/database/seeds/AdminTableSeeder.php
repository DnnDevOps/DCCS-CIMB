<?php

use Illuminate\Database\Seeder;
use ObeliskAdmin\Admin;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::firstOrNew(['username' => 'admin']);
        $admin->password = 'admin';
        $admin->fullname = 'Administrator';
        $admin->save();
    }
}
