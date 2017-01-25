<?php

use Illuminate\Database\Seeder;

class MedicinTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 5000;

        for ($i = 0; $i < $limit; $i++) {
            DB::table('medicine')->insert([ //,
                'name' => $faker->unique()->company,
                'code' => $faker->unique()->buildingNumber,
                'medicine_type_id' => rand(1, 3),
                'generic_id' => rand(1, 2),
                'price' => $faker->randomNumber,
                'manufactuer_id' => rand(1, 10),
                'status' => 1,
                'presentation' => $faker->paragraph,
                'descriptions' => $faker->paragraph,
                'indications' => $faker->paragraph,
                'dosage_administration' => $faker->paragraph,
                'side_effects' => $faker->paragraph,
                'precaution' => $faker->paragraph,
            ]);
        }
    }
}
