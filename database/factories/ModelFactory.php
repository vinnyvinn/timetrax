<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

//$factory->define(App\User::class, function (Faker\Generator $faker) {
//    static $password;
//
//    return [
//        'name' => $faker->name,
//        'email' => $faker->unique()->safeEmail,
//        'password' => $password ?: $password = bcrypt('secret'),
//        'remember_token' => str_random(10),
//    ];
//});


$factory->define(App\Employee::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'payroll_number' => $faker->unique()->numberBetween()
    ];
});

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'=> $faker->userName,
        'email' => $faker->safeEmail,
        'password' => bcrypt("password"),
        'role_id' => 1
    ];
});
