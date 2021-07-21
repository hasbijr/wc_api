<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * seed administrator
         */
        $user = new User();
        $user->username = '930071';
        $user->email = null;
        $user->email_verified_at = null;
        $user->password = Hash::make('secret');
        $user->save();

        $userinfo = new UserInformation();
        $userinfo->nama = 'Default Administrator';
        $user->userinformation()->save($userinfo);

        $user->assignRole('Administrator');

        /**
         * seed agent
         */
        $agents = range(900001, 900020);
        foreach ($agents as $key => $agent) {
            $agentmodel = new User();
            $agentmodel->username = $agent;
            $agentmodel->email = null;
            $agentmodel->email_verified_at = null;
            $agentmodel->password = Hash::make('secret');
            $agentmodel->save();

            $agentmodelinfo = new UserInformation();
            $agentmodelinfo->nama = 'Default Agent ' . $key;
            $agentmodel->userinformation()->save($agentmodelinfo);

            $agentmodel->assignRole('Agen');
        }
    }
}
