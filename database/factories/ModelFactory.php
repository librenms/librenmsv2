<?php
/*
 * Copyright (C) 2016 Tony Murray <murraytony@gmail.com>
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

use App\Models\Device;
use App\Models\Notification;
use App\Models\Port;
use App\Models\User;
use Database\Factories\FactoryData;

$factory->define(User::class, function(Faker\Generator $faker) {
    return [
        'username' => $faker->username,
        'realname' => $faker->name,
        'email'    => $faker->email,
        'password' => bcrypt(str_random(10)),
    ];
});


$factory->define(Device::class, function(Faker\Generator $faker) {
    return [
        'hostname'      => $faker->domainWord.'.'.$faker->domainName,
        'ip'            => $faker->randomElement([$faker->ipv4, $faker->ipv6]),
        'status'        => $status = random_int(0, 1),
        'status_reason' => $status == 0 ? $faker->randomElement(['snmp', 'icmp']) : '', // allow invalid states?
    ];
});


$factory->define(Port::class, function(Faker\Generator $faker) {
    return [
        'ifIndex' => $faker->unique()->numberBetween(),
        'ifType'  => $faker->randomElement(FactoryData::$IFTYPE_VALID_VALUES),
    ];
});

$factory->define(Notification::class, function(Faker\Generator $faker) {
    return [
        'title'    => $faker->sentence(8, true),
        'body'     => $faker->text(1000),
        'source'   => $faker->randomElement(['misc/notifications.rss', 'http://www.librenms.org/notifications.rss', '1']),
        'checksum' => $faker->sha256,
        'datetime' => $faker->dateTime->format('Y-m-d H:i:s'),
    ];
});
