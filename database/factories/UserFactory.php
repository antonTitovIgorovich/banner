<?php

use Faker\Generator as Faker;
use App\Entity\User;
use Illuminate\Support\Str;
use Carbon\Carbon;


$factory->define(User::class, function (Faker $faker) {
    $active = $faker->boolean;
    $phoneActivate = $faker->boolean;
    return array(
        'name' => $faker->name,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'phone_verified' => $phoneActivate,
        'phone' => $faker->unique()->phoneNumber,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'verify_token' => $active ? null : Str::uuid(),
        'phone_verify_token' => $phoneActivate ? null : Str::uuid(),
        'phone_verify_token_expire' => $phoneActivate ? null : Carbon::now()->addSeconds(300),
        'role' => $active ? $faker->randomElement([User::ROLE_USER, User::ROLE_ADMIN]) : User::ROLE_USER,
        'status' => $active ? User::STATUS_ACTIVE : User::STATUS_WAIT,
    );
});
