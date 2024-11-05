<?php

use App\Booking;
use App\Car;
use App\Customer;
use App\Driver;
use App\Location;
use App\Payment;
use App\Role;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $roles = [
            ['name' => 'admin'],
            ['name' => 'driver'],
        ];
        Role::insert($roles);

        $users = [];
        for ($i = 0; $i < 10; $i++) {
            $users[] = [
                'username' => 'user_' . $i,
                'password' => Hash::make('password'),
                'email' => "user{$i}@example.com",
                'role_id' => rand(1, 2),
            ];
        }
        User::insert($users);

        $customers = [];
        for ($i = 0; $i < 50; $i++) {
            $customers[] = [
                'identification_type' => $faker->randomElement(['passport', 'id_card']),
                'identification_num' => $faker->unique()->regexify('[A-Z0-9]{8}'),
                'name' => $faker->name,
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
            ];
        }
        Customer::insert($customers);

        $locations = [];
        for ($i = 0; $i < 10; $i++) {
            $locations[] = [
                'address' => $faker->address,
                'latitude' => $faker->latitude,
                'longitude' => $faker->longitude,
            ];
        }
        Location::insert($locations);

        $cars = [];
        for ($i = 0; $i < 50; $i++) {
            $cars[] = [
                'registration_number' => strtoupper($faker->bothify('??-###-??')),
                'model_name' => $faker->word,
                'model_year' => $faker->year,
                'total_kilometers' => $faker->numberBetween(10000, 200000),
                'luggage_capacity' => $faker->numberBetween(1, 5),
                'passenger_capacity' => $faker->numberBetween(2, 7),
                'daily_rate' => $faker->numberBetween(50, 300),
                'late_fee_per_hour' => $faker->numberBetween(5, 20),
                'is_available' => $faker->boolean,
                'rate_per_kilometer' => $faker->randomFloat(2, 0.1, 2),
            ];
        }
        Car::insert($cars);

        $drivers = [];
        for ($i = 0; $i < 10; $i++) {
            $drivers[] = [
                'name' => $faker->name,
                'daily_rate' => $faker->numberBetween(50, 150),
                'license_number' => $faker->unique()->regexify('[A-Z0-9]{8}'),
                'phone_number' => $faker->phoneNumber,
                'is_available' => $faker->boolean,
            ];
        }
        Driver::insert($drivers);

        $bookings = [];
        for ($i = 0; $i < 50; $i++) {
            $bookings[] = [
                'rental_start_time' => $faker->dateTimeBetween('now', '+1 month'),
                'rental_end_time' => $faker->dateTimeBetween('+1 month', '+2 months'),
                'total_amount' => $faker->numberBetween(100, 2000),
                'status' => $faker->randomElement(['Pending', 'Confirmed', 'Cancelled', 'Completed']),
                'driver_included' => $faker->boolean,
                'car_id' => $faker->numberBetween(1, 50),
                'customer_id' => $faker->numberBetween(1, 50),
                'pickup_location_id' => $faker->numberBetween(1, 10),
                'dropoff_location_id' => $faker->numberBetween(1, 10),
            ];
        }
        Booking::insert($bookings);

        $payments = [];
        for ($i = 0; $i < 50; $i++) {
            $payments[] = [
                'payment_date' => $faker->date,
                'payment_status' => $faker->randomElement(['Pending', 'Paid', 'Failed']),
                'paid_amount' => $faker->numberBetween(50, 2000),
                'total_amount' => $faker->numberBetween(100, 2000),
                'tax_amount' => $faker->numberBetween(5, 100),
                'booking_id' => $faker->numberBetween(1, 50),
                'late_fee' => $faker->optional()->numberBetween(5, 50),
            ];
        }
        Payment::insert($payments);

        $drivers = Driver::all();
        $bookingIds = range(1, 50);
        shuffle($bookingIds);
        foreach ($drivers as $index => $driver) {
            $carIds = Car::inRandomOrder()->take(rand(1, 5))->pluck('id')->toArray();
            foreach ($carIds as $carId) {
                $driver->cars()->attach($carId, [
                    'driver_type' => $faker->randomElement(['customer', 'company']),
                ]);
            }
        }
    }
}
