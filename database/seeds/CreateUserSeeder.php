<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Account;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'jointoit@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'jointoit@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('super_admin');

        User::create([
            'first_name' => 'Ordinary',
            'last_name' => 'Admin',
            'email' => 'admin@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'admin@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('admin');

        User::create([
            'first_name' => 'Product',
            'last_name' => 'Manager',
            'email' => 'pm@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'pm@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('pm');


        $user = User::create([
            'first_name' => 'First',
            'last_name' => 'Client',
            'email' => 'client@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'client@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('client');

        $account = Account::create([
            'name' => 'Google Inc.',
            'owner_id' => $user->id
        ]);

        $account->users()->save($user);

        $user1 = User::create([
            'first_name' => 'Second',
            'last_name' => 'Client',
            'email' => 'client2@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'client2@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])
        ])->assignRole('client');

        $account1 = Account::create([
            'name' => 'Facebook',
            'owner_id' => $user1->id
        ]);

        $account1->users()->save($user1);

        User::create([
            'first_name' => 'First',
            'last_name' => 'Editor',
            'email' => 'fe@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'fe@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('editor');

        User::create([
            'first_name' => 'Second',
            'last_name' => 'Editor',
            'email' => 'se@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'se@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('editor');

        User::create([
            'first_name' => 'First',
            'last_name' => 'Writer',
            'email' => 'fw@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'fw@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('writer');

        User::create([
            'first_name' => 'Second',
            'last_name' => 'Writer',
            'email' => 'sw@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'sw@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('writer');

        User::create([
            'first_name' => 'Production',
            'last_name' => 'Manager',
            'email' => 'productionmanager@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'productionmanager@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('production');

        User::create([
            'first_name' => 'Partner',
            'last_name' => 'Manager',
            'email' => 'partnermanager@jointoit.com',
            'password' => bcrypt('xryRMDKLoyOVr03P'),
            'name' => 'partnermanager@jointoit.com',
            'photo' => 'user_anonim.png',
            'bgc' => serialize(['#' . dechex(mt_rand(1, 16777215)), '#' . dechex(mt_rand(1, 16777215))])

        ])->assignRole('partner');

    }
}
