<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class SettingUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $setting;
    public $value;

    /**
     * Create a new event instance.
     *
     * @param $setting
     * @param $value
     */
    public function __construct($setting, $value)
    {
        $this->setting = $setting;
        $this->value = $value;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [new PrivateChannel('settings'), new PrivateChannel('settings.'.$this->setting)];
    }
}
