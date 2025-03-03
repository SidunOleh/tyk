<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Notifications\UserCredentials;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendUserCredentials
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
    public function handle(UserCreated $event): void
    {
        $event->user->notify(new UserCredentials(
            $event->user,
            $event->password
        ));
    }
}
