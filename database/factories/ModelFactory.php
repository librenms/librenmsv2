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

use App\Models\Alerting\Alert;
use App\Models\Alerting\Log;
use App\Models\Dashboard;
use App\Models\Device;
use App\Models\General\Inventory;
use App\Models\General\IPv4;
use App\Models\General\IPv4Mac;
use App\Models\General\IPv6;
use App\Models\General\Syslog;
use App\Models\Notification;
use App\Models\Port;
use App\Models\User;
use App\Models\UsersWidgets;
use App\Models\Widgets;

/** @var \Illuminate\Database\Eloquent\Factory $factory */

$factory->define(User::class, function (Faker\Generator $faker) {
    return [
        'username'  => $faker->username,
        'realname'  => $faker->name,
        'email'     => $faker->email,
        'password'  => str_random(10),
    ];
});

$factory->state(User::class, 'admin', function (Faker\Generator $faker) {
    return ['level' => 10];
});

$factory->state(User::class, 'globalread', function (Faker\Generator $faker) {
    return ['level' => 5];
});

$factory->define(Dashboard::class, function (Faker\Generator $faker) {
    return [
        'dashboard_name' => $faker->text(50),
    ];
});

$factory->define(Device::class, function (Faker\Generator $faker) {
    return [
        'hostname'      => $faker->domainWord.'.'.$faker->domainName,
        'ip'            => $faker->randomElement([$faker->ipv4, $faker->ipv6]),
        'status'        => $status = random_int(0, 1),
        'status_reason' => $status == 0 ? $faker->randomElement(['snmp', 'icmp']) : '', // allow invalid states?
    ];
});


$factory->define(Port::class, function (Faker\Generator $faker) {
    return [
        'ifIndex'      => $faker->unique()->numberBetween(),
        'ifName'       => $faker->text(20),
        'ifLastChange' => $faker->dateTimeThisYear(),
    ];
});

$factory->define(Notification::class, function (Faker\Generator $faker) {
    return [
        'title'    => $faker->sentence(8, true),
        'body'     => $faker->text(1000),
        'source'   => $faker->randomElement(['misc/notifications.rss', 'http://www.librenms.org/notifications.rss', '1']),
        'checksum' => $faker->sha256,
        'datetime' => $faker->dateTime->format('Y-m-d H:i:s'),
    ];
});

$factory->define(Alert::class, function (Faker\Generator $faker) {
    return [
        'device_id' => $faker->randomDigitNotNull(),
        'rule_id'   => $faker->randomDigitNotNull(),
        'state'     => $faker->randomElement($array = array(1,2)),
        'alerted'   => $faker->randomElement($array = array(0,1)),
        'open'      => $faker->randomElement($array = array(0,1)),
        'timestamp' => $faker->dateTime->format('Y-m-d H:i:s'),
    ];
});

$factory->define(Log::class, function (Faker\Generator $faker) {
    return [
        'rule_id'     => $faker->randomDigitNotNull(),
        'device_id'   => $faker->randomDigitNotNull(),
        'state'       => $faker->randomElement($array = array(1,2)),
        'details'     => '',
        'time_logged' => $faker->dateTime->format('Y-m-d H:i:s'),
    ];
});

$factory->define(Syslog::class, function (Faker\Generator $faker) {
    return [
        'device_id' => $faker->randomDigitNotNull(),
        'facility'  => 'syslog',
        'priority'  => 'info',
        'level'     => 'info',
        'tag'       => '2e',
        'timestamp' => $faker->dateTime->format('Y-m-d H:i:s'),
        'program'   => 'SYSLOG',
        'msg'       => $faker->realText(),
    ];
});

$factory->define(Inventory::class, function (Faker\Generator $faker) {
    return [
        'device_id'               => $faker->randomDigitNotNull(),
        'entPhysicalIndex'        => $faker->randomDigitNotNull(),
        'entPhysicalDescr'        => $faker->realText(),
        'entPhysicalClass'        => 'chassis',
        'entPhysicalName'         => 'Chassis',
        'entPhysicalModelName'    => $faker->realText(10),
        'entPhysicalSerialNum'    => $faker->bothify('#?#?#?#???##'),
        'entPhysicalContainedIn'  => $faker->randomDigit(),
        'entPhysicalParentRelPos' => $faker->randomDigit(),
        'entPhysicalMfgName'      => $faker->company(),
    ];
});

$factory->define(IPv4::class, function (Faker\Generator $faker) {
    return [
        'ipv4_address'    => $faker->ipv4(),
        'ipv4_prefixlen'  => $faker->randomElement($array = array ('8','16','24','32')),
        'ipv4_network_id' => $faker->randomDigitNotNull(),
        'port_id'         => $faker->randomDigitNotNull(),
    ];
});

$factory->define(IPv6::class, function (Faker\Generator $faker) {
    return [
        'ipv6_address'    => $faker->ipv6(),
        'ipv6_compressed' => $faker->ipv6(),
        'ipv6_prefixlen'  => $faker->randomElement($array = array ('32','64','128')),
        'ipv6_origin'     => 'manual',
        'ipv6_network_id' => $faker->randomDigitNotNull(),
        'port_id'         => $faker->randomDigitNotNull(),
    ];
});

$factory->define(IPv4Mac::class, function (Faker\Generator $faker) {
    return [
        'port_id'      => $faker->randomDigitNotNull(),
        'mac_address'  => $faker->macAddress(),
        'ipv4_address' => $faker->ipv4(),
    ];
});

$factory->define(Widgets::class, function (Faker\Generator $faker) {
    return [
        'widget_title'    => $faker->text(20),
        'widget'          => $faker->regexify('[a-z\-]{4,12}'),
        'base_dimensions' => $faker->randomDigitNotNull.', '.$faker->randomDigitNotNull,
    ];
});

$factory->define(UsersWidgets::class, function (Faker\Generator $faker) use ($factory) {
    return [
        'col'       => 1,
        'row'       => 2,
        'size_x'    => 1,
        'size_y'    => 2,
        'title'     => $faker->text(20),
        'widget_id' => $factory->create(Widgets::class)->widget_id,
        'settings'  => '',
    ];
});
