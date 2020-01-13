<?php

use Illuminate\Database\Seeder;

class BookingTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //town hall NO 1
        DB::table('booking_tax_types')->insert([
            ['place' => 'Town Hall No 1', 'event' => 'Weeding Function', 'parent_id' => 1],
            ['place' => 'Town Hall NO 1', 'event' => 'Musical shows, Dramas, Circus and karata shows', 'parent_id' => 2],
            ['place' => 'Town Hall NO 1', 'event' => 'If no entertainment tax is charged above shows', 'parent_id' => 3],
            ['place' => 'Town Hall NO 1', 'event' => 'For any exhibition ,Public Dancing Show', 'parent_id' => 4],
            ['place' => 'Town Hall NO 1', 'event' => 'Functions of Entertainment Any other functions, organized Function of Local or Foreign Dancing -non paying', 'parent_id' => 5],
            ['place' => 'Town Hall NO 1', 'event' => 'Exhibitions, Displays, or Functions based on free charging, of books, Magazines  and Plastic Goods, Electrical Goods and Sale of Flowers and Furniture ', 'parent_id' => 6],
            ['place' => 'Town Hall NO 1', 'event' => 'Paying Exhibition not Coming under 1.5', 'parent_id' => 7],
            ['place' => 'Town Hall NO 1', 'event' => 'Day and Night Banquets not based on free charging', 'parent_id' => 8],
            ['place' => 'Town Hall NO 1', 'event' => 'Holding Classes, Training programmers and Educational Seminars', 'parent_id' => 9],
            ['place' => 'Town Hall NO 1', 'event' => 'Public Lectures, Political Seminars Religious Festivals, School Prize giving functions', 'parent_id' => 10],
            ['place' => 'Town Hall NO 1', 'event' => 'Religious Festivals, School Prize giving functions, religious interviews, School Children sport training and Variety entertainment', 'parent_id' => 11],
            ['place' => 'Town Hall NO 1', 'event' => 'Any other free charging Services not herein mentioned', 'parent_id' => 12],
            ['place' => 'Town Hall NO 1', 'event' => 'For preschool festival', 'parent_id' => 13],
            ['place' => 'Town Hall NO 1', 'event' => 'For free charging Exhibition of Footwear and Apparels', 'parent_id' => 14],
            ['place' => 'Town Hall NO 1', 'event' => 'For Literary Festivals', 'parent_id' => 15],
            ['place' => 'Town Hall NO 1', 'event' => 'For International Pre School, International School', 'parent_id' => 16],
            ['place' => 'Town Hall NO 1', 'event' => 'non- free charging which is not mentioned hereinbefore', 'parent_id' => 17],
            ['place' => 'Town Hall NO 1', 'event' => 'For workshop on beauty culture and cookery', 'parent_id' => 18],
            ['place' => 'Town Hall NO 1', 'event' => 'other event', 'parent_id' => 19],

        ]);
         //Town hall No 2
        DB::table('booking_tax_types')->insert([
            ['place' => 'Town Hall No 2', 'event' => 'Weeding Function', 'parent_id' => 20],
            ['place' => 'Town Hall No 2', 'event' => 'For meetings, Displays, Discussion, Exhibition, Seminars', 'parent_id' => 21],
            ['place' => 'Town Hall No 2', 'event' => 'Display of sales and fairs (Finished Garments and Footwear Etc,)', 'parent_id' => 22],
            ['place' => 'Town Hall No 2', 'event' => 'Any other function  performed for cash not mentioned hereinbefore', 'parent_id' => 23],
            ['place' => 'Town Hall No 2', 'event' => 'Any other non chargeable function not mentioned hereinbefore', 'parent_id' => 24],
            ['place' => 'Town Hall No 2', 'event' => 'Day and Night Banquets not based on free charging', 'parent_id' => 25],
            ['place' => 'Town Hall No 2', 'event' => 'For workshop on beauty culture and cookery', 'parent_id' => 26],
            ['place' => 'Town Hall NO 2', 'event' => 'other event', 'parent_id' => 27],

        ]);
          // stadium
        DB::table('booking_tax_types')->insert([
            ['place' => 'Stadium', 'event' => 'Weeding Function', 'parent_id' => 28],
            ['place' => 'Stadium', 'event' => 'Functions of Entertainment Any other functions, organized Function of Local or Foreign Dancing', 'parent_id' => 29],
            ['place' => 'Stadium', 'event' => 'Exhibitions, Displays, or Functions based on cash transactions, of books, Magazines  and Plastic Goods, and Sale of Flowers and Furniture', 'parent_id' => 30],
            ['place' => 'Stadium', 'event' => 'Exhibitions based on Cash transactions and Exhibitions not covered under 3.3 above', 'parent_id' => 31],
            ['place' => 'Stadium', 'event' => 'Day and Night Banquets not based on free charging', 'parent_id' => 32],
            ['place' => 'Stadium', 'event' => 'Holding Classes, Training programmers and Educational Seminars', 'parent_id' => 33],
            ['place' => 'Stadium', 'event' => 'Public Lectures, Political Seminars Religious Festivals, School Prize giving functions', 'parent_id' => 34],
            ['place' => 'Stadium', 'event' => 'Any other paying Services not herein mentioned', 'parent_id' => 35],
            ['place' => 'Stadium', 'event' => 'Any other non-charging Services not herein mentioned', 'parent_id' => 36],
            ['place' => 'Stadium', 'event' => 'Display of sales and fairs (Apperals Electrical Appliances, Footwear etc)', 'parent_id' => 37],
            ['place' => 'Stadium', 'event' => 'Literary festivals, Commemoration', 'parent_id' => 38],
            ['place' => 'Stadium', 'event' => 'For night Lodging', 'parent_id' => 39],
            ['place' => 'Stadium', 'event' => 'For watching international Cricket Tests', 'parent_id' => 40],
            ['place' => 'Stadium', 'event' => 'International preschool, International School', 'parent_id' => 41],
            ['place' => 'Stadium', 'event' => 'For watching other games which hold.', 'parent_id' => 42],
            ['place' => 'Stadium', 'event' => 'for Workshops of Beauty Culture and Cookery', 'parent_id' => 43],
            ['place' => 'Stadium', 'event' => 'other event', 'parent_id' => 44],
        ]);
         //samanala Ground
        DB::table('booking_tax_types')->insert([
            ['place' => 'Samanala Ground', 'event' => 'For Meetings of political, Trade union and others', 'parent_id' => 45],
            ['place' => 'Samanala Ground', 'event' => 'For Musical shows +', 'parent_id' => 46],
            ['place' => 'Samanala Ground', 'event' => 'Non chargeable  Musical show ', 'parent_id' => 47],
            ['place' => 'Samanala Ground', 'event' => 'For any Sport Event-For School Children', 'parent_id' => 48],
            ['place' => 'Samanala Ground', 'event' => 'For any Sport Event - other', 'parent_id' => 49],
            ['place' => 'Samanala Ground', 'event' => 'For any series of Sport events-For School Children', 'parent_id' => 50],
            ['place' => 'Samanala Ground', 'event' => 'For any series of Sportevent-other', 'parent_id' => 51],
            ['place' => 'Samanala Ground', 'event' => 'For a circus', 'parent_id' => 52],
            ['place' => 'Samanala Ground', 'event' => 'For any sports Event held at National, Provincial, Divisional level by State or Any Sports activity concerned with preschools ', 'parent_id' => 53],
            ['place' => 'Samanala Ground', 'event' => 'For any Sale or Fair', 'parent_id' => 54],
            ['place' => 'Samanala Ground', 'event' => 'For other Sports Festival (including International School)', 'parent_id' => 55],
            ['place' => 'Samanala Ground', 'event' => 'For Landing Air craft', 'parent_id' => 56],
            ['place' => 'Samanala Ground', 'event' => 'For any other services not mentioned hereinbefore per day', 'parent_id' => 57],
            ['place' => 'Samanala Ground', 'event' => 'For sport practices', 'parent_id' => 58],
            ['place' => 'Samanala Ground', 'event' => 'other event', 'parent_id' => 59],

        ]);
          //Hiyare tank
        DB::table('booking_tax_types')->insert([
            ['place' => 'Hiyare Tank Ground', 'event' => 'for the reservation of the ground', 'parent_id' => 60],
            ['place' => 'Hiyare Tank Ground', 'event' => 'Other event', 'parent_id' => 61],
        ]);
         //dharmapala graden
        DB::table('booking_tax_types')->insert([
            ['place' => 'Dharmapala Garden', 'event' => 'For a Festival day', 'parent_id' => 62],
            ['place' => 'Dharmapala Garden', 'event' => 'charge for decorations and display of Notice of publicity ', 'parent_id' => 63],
            ['place' => 'Dharmapala Garden', 'event' => 'For a Monthly Festival day', 'parent_id' => 64],
            ['place' => 'Dharmapala Garden', 'event' => 'other event', 'parent_id' => 65],

        ]);

        DB::table('booking_tax_types')->insert([
            ['place' => 'Central Bus stand open air in uppermost Floor', 'event' => 'for a single night Banquet', 'parent_id' => 66],
        ]);
        DB::table('booking_tax_types')->insert([
            ['place' => 'Other Places', 'event' => 'Milidduwa Sports Ground', 'parent_id' => 67],
            ['place' => 'Other Places', 'event' => 'For Festivals and Meetings on any road within Municipal Area  not obstructing free transport', 'parent_id' => 68],
            ['place' => 'Other Places', 'event' => 'other event', 'parent_id' => 69],
        ]);
    }
}
