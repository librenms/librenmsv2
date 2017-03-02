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
namespace Tests\Unit;

use App\Models\User;
use Auth;
use Cache;
use Config;
use Settings;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SettingsTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        $user = factory(User::class)->create(['level' => 10]);
        Auth::login($user);
    }

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

    public function testReadOnly()
    {
        $this->assertFalse(Settings::isReadOnly('test.writable'));

        $user = factory(User::class)->create();
        Auth::login($user);

        $this->assertTrue(Settings::isReadOnly('test.roauth'));
    }

    /**
     * @expectedException \Exception
     */
    public function testReadOnlyException()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        Settings::set('test.readonly');
    }

    public function testSubtree()
    {
        $expected['key']['data'] = 'value';

        Settings::set('test.subtree.key.data', 'value');
        $result = Settings::get('test.subtree');

        $this->assertEquals($expected, $result);
    }

    public function testConfigSubtree()
    {
        $expected = ['firstname' => 'Billy', 'lastname' => 'Joel'];
        Config::set('config.test.indexed.subtree', $expected);
        $result = Settings::get('test.indexed.subtree');

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

    public function testConfigOnly()
    {
        Config::set('config.test.key', 'value');
        $result = Settings::get('test.key');

        $this->assertEquals('value', $result);
    }

    public function testConfigOverride()
    {
        Config::set('config.test.override', 'config');
        Settings::flush();
        Settings::set('test.override', 'settings');
        $result = Settings::get('test.override');

        $this->assertEquals('settings', $result);

        Settings::set('test.override', null);
        $this->assertNull(Settings::get('test.override'));
    }

    public function testConfigMergeSimple()
    {
        Settings::set('test.merge.simple', 'value');
        Config::set('config.test.merge.simple', 'configvalue');
        $result = Settings::get('test.merge.simple');

        $this->assertEquals('value', $result);
    }

    public function testConfigMergeMismatch()
    {
        $data = ['value1', 'value2'];

        Settings::set('test.mismatch', 'value');
        Config::set('config.test.mismatch', $data);
        $result = Settings::get('test.mismatch');

        $this->assertEquals('value', $result);
    }

    public function testConfigMergeMultiple()
    {
        $expected = [
            'one'   => 'config1',
            'two'   => 'settings2',
            'three' => 'settings3',
        ];
        Config::set('config.mm', ['one' => 'config1', 'two' => 'config2']);
        Settings::set('mm', ['two' => 'settings2', 'three' => 'settings3']);
        $result = Settings::get('mm');

        $this->assertEquals($expected, $result);
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

    public function testMixKeyArray()
    {
        Settings::set('test.mix', ['with.period' => 'value']);
        $result = Settings::get('test.mix');

        $this->assertEquals(['with' => ['period' => 'value']], $result);
    }

    public function testNumericArray()
    {
        $expected = ['zero', 'one', 'two'];
        Settings::set('test.array.0', 'zero');
        Settings::set('test.array.2', 'two');
        Settings::set('test.array.1', 'one');

        $result = Settings::get('test.array');

        $this->assertEquals($expected, $result);
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
        $cache1 = Cache::tags(\App\Settings::$cache_tag)->get('test.cache.one');
        $cache2 = Cache::tags(\App\Settings::$cache_tag)->get('test.cachetwo');
        $this->assertEquals('value1', $cache1);
        $this->assertEquals('value2', $cache2);
    }

    public function testFlushCache()
    {
        Settings::set('test.flush', 'value');
        $cached = Cache::tags(\App\Settings::$cache_tag)->get('test.flush');
        $this->assertEquals('value', $cached);

        Settings::set('test.another.flush', 'stuff');
        $expected = Settings::get('test');
        $result = Cache::tags(\App\Settings::$cache_tag)->get('test');
        $this->assertEquals($expected, $result);

        Settings::flush('test.another');
        $parent = Cache::tags(\App\Settings::$cache_tag)->get('test');
        $this->assertNull($parent);

        $child = Cache::tags(\App\Settings::$cache_tag)->get('test.another.flush');
        $this->assertEquals('stuff', $child);

        Settings::flush();
        $flushed = Cache::tags(\App\Settings::$cache_tag)->get('test.flush');
        $this->assertNull($flushed);
    }

    public function testNoCache()
    {
        Settings::set('test.nocache', 'value');
        Settings::flush();
        $result = Settings::get('test.nocache');

        $this->assertEquals('value', $result);
    }

    public function testNoCacheArray()
    {
        $expected = ['one' => 'value1', 'two' => 'value2'];
        Settings::set('test.nocachearray', $expected);
        Settings::flush();
        $result = Settings::get('test.nocachearray');

        $this->assertEquals($expected, $result);
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

    public function testParentCache()
    {
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
        $data = ['key1' => 'data1', 'key2' => ['key3' => 'data3'], 'install_dir' => './'];

        Settings::set("", $data);
        $result = Settings::all();

        $this->assertEquals($data, $result);
    }

    public function testArrayOfPaths()
    {
        $data = ['test.path1' => 'value1', 'test.deep.path2' => 'value2'];
        $expected = ['path1' => 'value1', 'deep' => ['path2' => 'value2']];

        Settings::set('', $data);
        $result = Settings::get('test');

        $this->assertEquals($expected, $result);
    }

    public function testArrayWithValue()
    {
        $data = ['value', 'arr' => ['one' => 'one', 'two' => 'two']];

        Settings::set('test.arrayval', $data);

        $result1 = Settings::get('test.arrayval.arr.two');
        $this->assertEquals('two', $result1);

        $result2 = Settings::get('test.arrayval.0');
        $this->assertEquals('value', $result2);
    }

    public function testSubpathValue()
    {
        Settings::set('test.subpath', 'value');

        try {
            Settings::set('test.subpath', ['one' => 'one', 'two' => 'two']);
            $this->fail("Unreachable line");
        } catch (\Exception $e) {
            $this->assertEquals("Attempting to set array value to existing non-array value at the key 'test.subpath'", $e->getMessage());
        }

        $result1 = Settings::get('test.subpath');
        $this->assertEquals('value', $result1);

        $result2 = Settings::get('test.subpath.one');
        $this->assertNull($result2);
    }

    public function testSubkey()
    {
        Settings::set('key', 'value');
        Settings::set('keysub', 'value');
        $this->assertEquals('value', Settings::get('key'));

        Settings::flush();
        $this->assertEquals('value', Settings::get('key'));
    }

    public function testHas()
    {
        Settings::set('has.one', 'value');
        $this->assertTrue(Settings::has('has.one'));

        Config::set('config.has.two', 'value');
        $this->assertTrue(Settings::has('has.two'));

        Cache::tags(\App\Settings::$cache_tag)->put('has.three', 'value', 5);
        $this->assertTrue(Settings::has('has.three'));

        $this->assertTrue(Settings::has('has'));

        $this->assertFalse(Settings::has('nothing'));
    }

    public function testForget()
    {
        Settings::set('test.forget', ['array', 'of', 'things', ['and', 'stuff']]);
        $this->assertTrue(Settings::has('test.forget.3.1'));
        Settings::forget('test.forget');
        $this->assertFalse(Settings::has('test.forget'));
        $this->assertFalse(Settings::has('test.forget.3.1'));

        Config::set('config.test.cant.forget', 'value');
        Settings::forget('test.cant.forget');
        $this->assertTrue(Settings::has('test.cant.forget'));
    }

    public function testPrepend()
    {
        Settings::set('test.prepend', 'one');
        Settings::prepend('test.prepend', 'two');
        $expected = ['two', 'one'];
        $result = Settings::get('test.prepend');
        $this->assertEquals($expected, $result);

        Settings::prepend('test.prepend', 'three');
        $expected = ['three', 'two', 'one'];
        $result = Settings::get('test.prepend');
        $this->assertEquals($expected, $result);

        Settings::prepend('test.prepend.new', 'value');
        $result = Settings::get('test.prepend.new');
        $this->assertEquals(['value'], $result);
    }

    public function testPush()
    {
        Settings::set('test.push', 'one');
        Settings::push('test.push', 'two');
        $expected = ['one', 'two'];
        $result = Settings::get('test.push');
        $this->assertEquals($expected, $result);

        Settings::push('test.push', 'three');
        $expected = ['one', 'two', 'three'];
        $result = Settings::get('test.push');
        $this->assertEquals($expected, $result);

        Settings::push('test.push.new', 'value');
        $result = Settings::get('test.push.new');
        $this->assertEquals(['value'], $result);
    }

    public function testTypes()
    {
        Settings::set('test.type.bool', true);
        $this->assertTrue(Settings::get('test.type.bool'));

        Settings::set('test.type.int', 5);
        $this->assertEquals(5, Settings::get('test.type.int'));

        Settings::set('test.type.string', "String Thing");
        $this->assertEquals("String Thing", Settings::get('test.type.string'));
    }
}
