<?php

namespace App\Events;

use App\Models\DbConfig;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Log;

class SettingDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public $setting;

    /**
     * Create a new event instance.
     *
     * @param $setting
     */
    public function __construct(DbConfig $setting)
    {
        Log::info($setting);
        $this->setting = $setting->config_name;
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
