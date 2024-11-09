<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use Faker\Factory as Faker;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 1000; $i++) {

        // Use Faker to generate fake data
        $faker = Faker::create();

        // Create a user first
        $user = User::create([
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'password' => bcrypt('00000000'), // You can adjust the password logic as needed
            'role' => 'wholesaler', // Set role to 'wholesaler'
        ]);

        // Create a supplier associated with the user
        Supplier::create([
            'user_id' => $user->id,
            'name' => $faker->company,
            'contact_name' => $faker->name,
            'contact_email' => $faker->email,
            'contact_phone' => $faker->phoneNumber,
            'address' => $faker->address,
            'city' => $faker->city,
            'country' => $faker->country,
            'logo' => $faker->imageUrl(), // You can modify this to be a path to an actual image if needed
        ]);
    }
    }
}
