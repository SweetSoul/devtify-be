<?php

namespace App\Providers;

use App\Models\Workshop;
use App\Providers\BalanceChanged;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterTransaction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Providers\BalanceChanged  $event
     * @return void
     */
    public function handle(UserBalanceChanged $event)
    {
        $user = $event->user;
        if ($event->balance > $user->balance) {
            $amount = -$event->item->price;
            $type = 'purchase';
            $description = "Purchased {$event->item->title}";
        } else {
            $amount = $event->item->price;
            $type = 'workshop';
            $description = "Sold {$event->item->title}";
        }

        $user->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'description' => $description,
            'origin' => $event->item instanceof Workshop ? 'Workshop' : 'Marketplace',
        ]);
    }
}
