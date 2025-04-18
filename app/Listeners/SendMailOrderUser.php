<?php

namespace App\Listeners;

use App\Events\OrderUserSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderUser;

class SendMailOrderUser implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderUserSuccess $event): void
    {
        Log::debug("MÃ code là: " . $event->order);

        $user = $event->user;
        $dataOrder = $event->dataOrder;
        $order = $event->order;

        // $email = new OrderUser($user, $dataOrder);
        // $user = Mail::to($user->email)->send($email);

        // Mail::to($user->email)->send(new OrderUser($user, $dataOrder, $order));
        Mail::to($user->email)->send(new OrderUser($user, $dataOrder, $order));

    }
}
