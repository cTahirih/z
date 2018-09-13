<?php
use Faker\Factory as FakerFactory;

$faker   = FakerFactory::create('es_PE');
$fixture = [];

for ($i = 0; $i < 100; $i++) {
    $fixture[] = [
        'customer_id' => ($i + 1),
        'prefix' => 'Mr',
        'first_name' => $faker->firstName(),
        'middle_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->safeEmail(),
        'registered_date' => $faker->dateTime()->format('Y-m-d'),
        'is_active' => '1',
        'newsletter_status' => '0',
        'points_balance' => $faker->numberBetween(0, 500),
        'points_delta' => $faker->randomElement([20, 60, 80]),
        'mobile' => '',
        'telephone' => $faker->numerify('########'),
        'address' => '',
        'zip_code' => '',
        'city' => 'Ica',
        'dob' => $faker->dateTime()->format('Y-m-d'),
        'region' => '',
        'country' => '',
        'segment' => $faker->randomElement(['gold', 'platinum']),
    ];
}

return $fixture;
