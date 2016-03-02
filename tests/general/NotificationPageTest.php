<?php

use App\User;

class NotificationPageTest extends TestCase
{

    /**
     * Test about page
    **/

    public function testNotificationPage()
    {

        $user = factory(User::class)->create();
        $unread = ['title' => 'Test unread notification', 'body' => 'Testing notifications', 'source' => 'http://www.librenms.org/notifications.rss', 'checksum' => '1', 'datetime' => 'NOW()'];
        DB::table('notifications')->insert($unread);
        $read = ['title' => 'Test read notification', 'body' => 'Testing notifications', 'source' => 'http://www.librenms.org/notifications.rss', 'checksum' => '2', 'datetime' => 'NOW()'];
        $id = DB::table('notifications')->insertGetId($read);
        $read_attrib = ['notifications_id' => $id, 'user_id' => $user->user_id, 'key' => 'read', 'value' => 1];
        DB::table('notifications_attribs')->insert($read_attrib);

        $this->actingAs($user)
             ->visit('/notifications')
             ->see('Show archive')
             ->see('Test unread notification');

        $this->actingAs($user)
             ->visit('/notifications/archive')
             ->see('Show notifications')
             ->see('Test read notification');
    }
}
