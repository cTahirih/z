<?php
use Faker\Factory as FakerFactory;

$faker   = FakerFactory::create('es_PE');
$fixture = [];

for ($i = 0; $i < 10; $i++) {
    $fixture[] = [
        'customer_id' => $i + 1,
        'entity_id' => $faker->numerify('####'),
        'segment' => 'gold',
        'created_at' => $faker->dateTimeBetween('2017-01-01', '2018-01-01')->format('Y-m-d H:i:s'),
    ];
}

return $fixture;
