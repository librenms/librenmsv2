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
/**
 * SettingsTest.php
 *
 * @package    LibreNMS
 * @author     Tony Murray <murraytony@gmail.com>
 * @copyright  2016 Tony Murray
 * @license    @license http://opensource.org/licenses/GPL-3.0 GNU Public License v3 or later
 */

class SettingsTest extends TestCase
{
    public function testSetGet()
    {
        Settings::set('test.setget', 'setget');
        $result = Settings::get('test.setget');

        $this->assertEquals('setget', $result);
    }

    public function testNonExistent()
    {
        $this->assertNull(Settings::get('non.existant.key'));
    }

    public function testDefault()
    {
        $result = Settings::get('test.default', 'default');

        $this->assertEquals('default', $result);
    }

    public function testConfigOnly()
    {
        Config::set('config.test.key', 'value');
        $result = Settings::get('test.key');

        $this->assertEquals('value', $result);
    }

    public function testSettingsOverride()
    {
        Config::set('test', 'config');
        Settings::set('test', 'settings');
        $result = Settings::get('test');

        $this->assertEquals('settings', $result);
    }

    public function testSubtree()
    {
        $expected['key']['data'] = 'value';

        Settings::set('test.subtree.key.data', 'value');
        $result = Settings::get('test.subtree');

        $this->assertEquals($expected, $result);
    }

    public function testRecursiveSetting()
    {
        $data = ['key1' => 'data1', 'key2' => ['key3' => 'data3']];
        Settings::set('test.recursive', $data);
        $result = Settings::get('test.recursive');

        $this->assertEquals($data, $result);
    }

    public function testPathSetting()
    {
        $data = [
            'key1'      => 'data1',
            'key2.key3' => 'data3',
        ];
        $expected = ['key1' => 'data1', 'key2' => ['key3' => 'data3']];

        Settings::set('test.path', $data);
        $result = Settings::get('test.path');

        $this->assertEquals($expected, $result);
    }

    public function testConfigMergeSimple() {
        Config::set('config.test.merge.simple', 'configvalue');
        Settings::set('test.merge.simple', 'value');
        $result = Settings::get('test.merge.simple');

        $this->assertEquals('value', $result);
    }

    public function testConfigMergeComplex()
    {
        $expected = [
            'config'   => 'c1',
            'settings' => 's1',
            'other'    => [
                'config_leaf'   => 'c2',
                'settings_leaf' => 's2',
            ]];

        Config::set('config.test.config', 'c1');
        Config::set('config.test.other', 's_unseen');
        Config::set('config.test.other.config_leaf', 'c2');
        Settings::set('test.settings', 's1');
        Settings::set('test.other.settings_leaf', 's2');
        $result = Settings::get('test');

        $this->assertEquals($expected, $result);
    }

    public function testConfigMergeMismatch() {
        $data = ['value1', 'value2'];

        Config::set('config.test.mismatch', 'value');
        Settings::set('test.mismatch', $data);
        $result = Settings::get('test.mismatch');

        $this->assertEquals($data, $result);
    }

    public function testMixKeyArray() //TODO: more tests in this area, is this valid or invalid behaviour?
    {
        Settings::set('test.mix', ['with.period' => 'value']);
        $result = Settings::get('test.mix');

        $this->assertEquals(['with' => ['period' => 'value']], $result);
    }

    public function testDeeperKey()
    {
        Settings::set('test.mix', ['with.period' => 'value']);
        $result = Settings::get('test.mix.with.period');

        $this->assertEquals('value', $result);
    }

    public function testCacheFill()
    {
        // set some values
        Settings::set('test.cache.one', 'value1');
        Settings::set('test.cachetwo', 'value2');

        // load the values into cache
        $value1 = Settings::get('test.cache.one');
        $value2 = Settings::get('test.cachetwo');
        $this->assertEquals('value1', $value1);
        $this->assertEquals('value2', $value2);

        // check the cache
        $cache1 = Cache::get('test.cache.one');
        $cache2 = Cache::get('test.cachetwo');
        $this->assertEquals('value1', $cache1);
        $this->assertEquals('value2', $cache2);
    }

    public function testMultipleSet()
    {
        Settings::set('test.m', 'one');
        Settings::set('test.m', 'two');
        Settings::get('test.m');
        Settings::set('test.m', 'three');
        $result = Settings::get('test.m');

        $this->assertEquals('three', $result);
    }

    public function testParentCache() {
        $predata = ['two', 'three', 'one'];
        $data = ['one', 'two', 'three'];

        Settings::set('test.order', $predata);
        Settings::get('test.order'); // fill cache
        Settings::set('test.order', $data);
        $result = Settings::get('test.order');

        $this->assertEquals($data, $result);
    }

    public function testGetAll()
    {
        $data = ['key1' => 'data1', 'key2' => ['key3' => 'data3']];

        Settings::set("", $data);
        $result = Settings::all();

        $this->assertEquals($data, $result);
    }
}
