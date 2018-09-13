<?php
use Faker\Factory as FakerFactory;

$faker   = FakerFactory::create('es_PE');
$fixture = [];

for ($i = 0; $i < 20; $i++) {
    $fixture[] = [
        'customer_id' => ($i + 1),
        'entity_id' => $faker->numerify('####'),
        'segment' => $faker->randomElement(['gold', 'platinum']),
        'created_at' => $faker->dateTimeBetween('2017-01-01 00:00:00', '2018-01-01 23:59:59')->format('Y-m-d H:i:s'),
    ];
}

return $fixture;
