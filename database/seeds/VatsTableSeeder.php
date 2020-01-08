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
            'name' => 'Business Tax',
            'vat_percentage' => 15,
            //vat and fine refered on seperate table
            'route'=> 'business',
            'due_date' => '0004-02-29',
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
            'route'=> 'license'
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
            'route'=> 'landauction'
        ]);
        DB::table('vats')->insert([
            'name' => 'Shop Rent Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'shoprent'
        ]);
        DB::table('vats')->insert([
            'name' => 'Vehical Park Tax',
            'vat_percentage' => 15,
            'fine_percentage'=> 10,
            'route'=> 'vehicalpark'
        ]);
        DB::table('vats')->insert([
            'name' => 'Entertainment Tax',
            'route'=> 'entertainment'
        ]);
        DB:: table('vats')->insert([
            'name' => 'Club Licence Tax',
            'vat_percentage' => 15,
            'route' => 'clubhouselicence',
        ]);
        DB:: table('vats')->insert([
            'name' => 'Three Wheel Park Tax',
            'vat_percentage' => 15,
            'route' => 'threewheelpark',
        ]);
        DB:: table('vats')->insert([
            'name' => 'Booking',
            'vat_percentage' => 15,
            'route' => 'booking',
        ]);
        DB:: table('vats')->insert([
            'name' => 'Slaughtering Tax',
            'vat_percentage' => 15,
            'route' => 'slaughtering',
        ]);
    }
}