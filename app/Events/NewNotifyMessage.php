<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewNotifyMessage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $id;
    public $type;
    public $title;
    public $body;
    public $link;
    public $image;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        $this->id = $message['id'];
        $this->type = $message['type'];
        $this->title = $message['title'];
        $this->body = $message['body'];
        $this->link = $message['link'];
        $this->image = $message['image'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */


    public function broadcastOn()
    {
        return ['new-Notify-message'];
    }
}
