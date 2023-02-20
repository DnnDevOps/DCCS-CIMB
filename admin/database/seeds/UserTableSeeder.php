<?php

use Illuminate\Database\Seeder;
use ObeliskAdmin\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        User::create(['username' => 'agent1', 'password' => 'pass123', 'fullname' => 'Agent Satu', 'level' => 'Agent', 'active' => true]);
        User::create(['username' => 'agent2', 'password' => 'pass123', 'fullname' => 'Agent Dua', 'level' => 'Agent', 'active' => true]);
        User::create(['username' => 'agent3', 'password' => 'pass123', 'fullname' => 'Agent Tiga', 'level' => 'Agent', 'active' => true]);
        User::create(['username' => 'agent4', 'password' => 'pass123', 'fullname' => 'Agent Empat', 'level' => 'Agent', 'active' => true]);
        User::create(['username' => 'agent5', 'password' => 'pass123', 'fullname' => 'Agent Lima', 'level' => 'Agent', 'active' => true]);
        
        User::create(['username' => 'manager1', 'password' => 'pass123', 'fullname' => 'Manager Satu', 'level' => 'Manager', 'active' => true]);
        
        User::create(['username' => 'spv1', 'password' => 'pass123', 'fullname' => 'Supervisor Satu', 'level' => 'Supervisor', 'active' => true])
            ->groupMember()->attach(['agent1', 'agent2', 'agent3', 'agent4', 'agent5', 'manager1']);
    }
}
