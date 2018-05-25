<?php

use Illuminate\Database\Seeder;
use App\Partner;
use App\Niche;
use App\Bsi;

class CreatePartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $partner = new Partner();
        $partner->domain = 'www.fake.com';
        $partner->cost = 39.99;
        $partner->month_placements = 0;
        $partner->description = 'Hello world!';
        $partner->dr = 12;
        $partner->tf = 34;
        $partner->cf = 21;
        $partner->da = 21;
        $partner->traffic = 10000;
        $partner->ref_domains = 12;
        $partner->first_name = 'Fake';
        $partner->last_name = 'Smith';
        $partner->company_name = 'Fake & partners';
        $partner->email = 'fake@mail.com';
        $partner->paypal_id = 'paypal@fake.com';
        $partner->photo = 'user_anonim.png';
        $partner->bsi()->associate(Bsi::find(2));
        $partner->niche()->associate(Niche::find(5));
        $partner->save();

        $partner = new Partner();
        $partner->domain = 'www.kisel.money';
        $partner->cost = 100;
        $partner->month_placements = 100;
        $partner->description = 'The perfect company as placements!';
        $partner->dr = 42;
        $partner->tf = 54;
        $partner->cf = 21;
        $partner->da = 51;
        $partner->traffic = 100000;
        $partner->ref_domains = 90;
        $partner->first_name = 'Maks';
        $partner->last_name = 'Kisel';
        $partner->company_name = 'Kisel Money';
        $partner->email = 'give@your.money';
        $partner->paypal_id = 'give@your.money';
        $partner->photo = 'user_anonim.png';
        $partner->bsi()->associate(Bsi::find(1));
        $partner->niche()->associate(Niche::find(10));
        $partner->save();
    }
}
