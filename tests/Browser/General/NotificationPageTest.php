<?php
namespace Tests\Browser\General;

use App\Models\Notification;
use App\Models\User;
use Auth;
use Tests\BrowserKitTestCase;

class NotificationPageTest extends BrowserKitTestCase
{

    /**
     * Test the notifications page
     **/

    public function testNotificationPage()
    {

        $user = factory(User::class)->create();

        /** @var Notification $unread */
        $unread = factory(Notification::class)->create();

        /** @var Notification $read */
        $read = factory(Notification::class)->create();
        Auth::login($user);
        $read->markRead();

        $this->actingAs($user)
            ->visit('/notifications')
            ->see('Archive')
            ->see($unread->title)
            ->dontSee($read->title)
            ->see("<ul class=\"timeline\">\n<li")
            ->click('show-notification')
            ->type('New Notification Title', 'title')
            ->type('Notification body text', 'body')
            ->press('Create notification')
            ->click('read');


        $this->actingAs($user)
            ->visit('/notifications/archive')
            ->see('Notifications')
            ->see($read->title)
            ->click('Mark as unread');

        Notification::each(function (Notification $notification) {
            $notification->markRead();
        });

        $this->actingAs($user)
            ->visit('/notifications')
            ->see('<ul class="timeline"></ul>');
    }
}
