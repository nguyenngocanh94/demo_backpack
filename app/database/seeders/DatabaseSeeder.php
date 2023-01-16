<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $coupon = new Coupon();
         $coupon->point = 1;
         $coupon->name = 'coupon test 01';
         $coupon->description = 'coupon test 01 for testing';
         $coupon->quota = 100;
         $coupon->uuid = Uuid::fromString('de811ec4-0e2c-48e5-9c25-29c2f2a806ad');
         $coupon->save();
    }
}
