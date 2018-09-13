<?php
use Faker\Factory as FakerFactory;

$faker   = FakerFactory::create('es_PE');
$fixture = [];

// Customer 1-7 will have random 2-8 machines
for ($customerId = 1; $customerId <= 7; $customerId++) {
    for ($i = 0; $i < rand(2, 8); $i++) {
        $fixture[] = [
            'order_id' => $faker->numerify('####'),
            'customer_id' => $customerId,
            'created_at' => $faker->dateTimeBetween('2018-01-01', '2018-12-31')->format('Y-m-d H:i:s'),
        ];
    }
}

// Customer 8-10 will have just one
for ($i = 8; $i <= 10; $i++) {
    $fixture[] = [
        'order_id' => $faker->numerify('####'),
        'customer_id' => $i,
        'created_at' => '2018-07-17 00:00:00',
    ];
}

return $fixture;
