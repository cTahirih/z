<?php
use Faker\Factory as FakerFactory;

$faker   = FakerFactory::create('es_PE');
$fixture = [];

for ($i = 0; $i < 10; $i++) {
    $fixture[] = [
        'customer_id' => ($i + 1),
        'points_balance' => $faker->numberBetween(0, 500),
        'segment' => $faker->randomElement(['gold', 'platinum']),
        'machine_acquisition_average' => 0,
        'created_at' => date('Y-m-d H:i:s'),
    ];
}

return $fixture;
