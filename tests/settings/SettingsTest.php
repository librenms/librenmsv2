<?php


class SettingsTest extends TestCase
{

    /**
     * A basic functional test example.
     *
     * @return void
     */

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

    public function testConfigDbMerging()
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


    public function testMixKeyArray() //TODO: more tests in this area, is this valid or invalid behaviour?
    {
        Settings::set('test.mix', ['with.period' => 'value']);
        $result = Settings::get('test.mix');

        $this->assertEquals(['with' => ['period' => 'value']], $result);
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

}
