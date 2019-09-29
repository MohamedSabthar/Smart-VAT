    <?php

use Illuminate\Database\Seeder;

class VatsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('vats')->insert([
            'name' => 'Buisness Tax',
            'vat_percentage' => 15,
            //vat and fine refered on seperate table
            'route'=> 'buisness'
        ]);

        DB::table('vats')->insert([
            'name' => 'Industrial Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'industrial'
        ]);

        DB::table('vats')->insert([
            'name' => 'Licence Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'licence'
        ]);

        DB::table('vats')->insert([
            'name' => 'Land Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'land'
        ]);

        DB::table('vats')->insert([
            'name' => 'Advertizement Tax',
            //vat and fine refered on sperate table
            'vat_percentage' => 15,
            'route'=> 'advertizement'
        ]);

        DB::table('vats')->insert([
            'name' => 'Land Auction Tax',
            'vat_percentage' => 1,
            'route'=> 'land-auction'
        ]);
        DB::table('vats')->insert([
            'name' => 'Shop Rent Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'shop-rent'
        ]);
        DB::table('vats')->insert([
            'name' => 'Vehical Park Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'vehical-park'
        ]);
        DB::table('vats')->insert([
            'name' => 'Entertancement And Performance tax',
            'vat_percentage' => 15,
            'route'=> 'entertancement-an-performance'
        ]);
        DB:: table('vats')->insert([
            'name' => 'Club House Licence Tax',
            'vat_percentage' => 15,
            'route' => 'club-house',
        ]);
        DB:: table('vats')->insert([
            'name' => 'Three Wheel Park Tax',
            'vat_percentage' => 15,
            'route' => 'three-wheel-park',
        ]);
        DB:: table('vats')->insert([
            'name' => 'Booking',
            'vat_percentage' => 15,
            'route' => 'booking',
        ]);
    }
}