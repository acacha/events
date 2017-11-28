<?php

use App\User;
use Faker\Generator as Faker;

use Acacha\Events\Models\Event;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->text,
        'user_id' => factory(User::class)->create()->id
    ];
});
