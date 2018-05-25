<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ProductTableSeeder::class);
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(CreateUserSeeder::class);
        $this->call(CreateProjectsseeder::class);

        $this->call(CreateClientSeeder::class);
        $this->call(CreateEditorSeeder::class);
        $this->call(CreateWriterSeeder::class);
        $this->call(CreateProductionManagerSeeder::class);
        $this->call(CreatePartnerManagerSeeder::class);

        $this->call(NewsFeedSeeder::class);

        $this->call(BSISeeder::class);
        $this->call(NichesSeeder::class);
        $this->call(CouponSeeder::class);

        $this->call(CreatePartnerSeeder::class);
        $this->call(OrderTableSeeder::class);

        $this->call(AliasBSISeeder::class);

    }
}
