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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
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
                'name' => $faker->name(),
                'username' => 'user_' . $i,
                'password' => Hash::make('password'),
                'email' => "user{$i}@example.com",
                'role_id' => rand(1, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        User::insert($users);

        $customers = [];
        for ($i = 0; $i < 50; $i++) {
            $customers[] = [
                'identification_num' => $faker->unique()->regexify('[A-Z0-9]{8}'),
                'name' => $faker->name,
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->safeEmail,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Customer::insert($customers);

        $locations = [
            ['address' => 'Latha', 'latitude' => 16.7660, 'longitude' => 96.1550],
            ['address' => 'Pazundaung', 'latitude' => 16.7771, 'longitude' => 96.1581],
            ['address' => 'Dagon', 'latitude' => 16.7830, 'longitude' => 96.1525],
            ['address' => 'Kamayut', 'latitude' => 16.7833, 'longitude' => 96.1458],
            ['address' => 'Tamwe', 'latitude' => 16.8044, 'longitude' => 96.1544],
            ['address' => 'Hlaing', 'latitude' => 16.8433, 'longitude' => 96.1427],
            ['address' => 'Sanchaung', 'latitude' => 16.7953, 'longitude' => 96.1541],
            ['address' => 'Thaketa', 'latitude' => 16.8048, 'longitude' => 96.1942],
            ['address' => 'Bahan', 'latitude' => 16.8203, 'longitude' => 96.1429],
            ['address' => 'Ahlone', 'latitude' => 16.7812, 'longitude' => 96.1573],
        ];

        foreach ($locations as &$location) {
            $location['created_at'] = now();
            $location['updated_at'] = now();
        }
        Location::insert($locations);

        $cars = [];
        for ($i = 0; $i < 50; $i++) {
            $cars[] = [
                'registration_number' => strtoupper($faker->bothify('??-###-??')),
                'model_name' => ucfirst($faker->word),
                'model_year' => $faker->year,
                'total_kilometers' => $faker->numberBetween(10000, 200000),
                'luggage_capacity' => $faker->numberBetween(1, 5),
                'passenger_capacity' => $faker->numberBetween(2, 7),
                'daily_rate' => $faker->numberBetween(50, 300),
                'late_fee_per_hour' => $faker->numberBetween(5, 20),
                'is_available' => $faker->boolean,
                'rate_per_kilometer' => $faker->randomFloat(2, 0.1, 2),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Car::insert($cars);

        $drivers = [];
        for ($i = 0; $i < 10; $i++) {
            $drivers[] = [
                'name' => $faker->name,
                'daily_rate' => $faker->numberBetween(40, 55),
                'license_number' => $faker->unique()->regexify('[A-Z0-9]{8}'),
                'phone_number' => $faker->phoneNumber,
                'is_available' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        Driver::insert($drivers);


        $carIds = Car::pluck('id')->all();
        $customerIds = Customer::pluck('id')->all();
        $locationIds = Location::pluck('id')->all();

        for ($i = 0; $i < 50; $i++) {
            $startDate = $faker->boolean(80) ? $faker->dateTimeBetween('now', '+1 month') : null;
            $endDate = $startDate ? $faker->dateTimeBetween($startDate, '+2 months') : null;

            $payment = Payment::create([
                'payment_status' => $faker->randomElement(['pending', 'paid', 'failed']),
                'total_amount' => $faker->randomFloat(2, 100, 2000),
                'tax_amount' => $faker->randomFloat(2, 5, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Booking::create([
                'booking_token' => base64_encode(Str::random(32)),
                'rental_start_date' => $startDate,
                'rental_end_date' => $endDate,
                'status' => $faker->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
                'is_driver_included' => $faker->boolean,
                'car_id' => $faker->randomElement($carIds),
                'customer_id' => $faker->randomElement($customerIds),
                'pickup_location_id' => $faker->randomElement($locationIds),
                'dropoff_location_id' => $faker->randomElement($locationIds),
                'payment_id' => $payment->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach (Driver::all() as $driver) {
            $assignedCarIds = Car::inRandomOrder()->take(rand(1, 5))->pluck('id')->all();
            foreach ($assignedCarIds as $carId) {
                $driver->cars()->attach($carId, [
                    'driver_type' => $faker->randomElement(['customer', 'company']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
