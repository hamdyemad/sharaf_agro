<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class newOrder implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $order;
    public $customer_name;
    public $main_category;
    public $sub_category;
    public $status;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->order = $data['order'];
        $this->customer_name = $data['customer_name'];
        $this->main_category = $data['main_category'];
        $this->sub_category = $data['sub_category'];
        $this->status = $data['status'];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('newOrder');
    }
}
