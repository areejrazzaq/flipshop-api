<?php

namespace App\Listeners;

use App\Http\Controllers\User\ProfileController;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;

class AddProfile
{
    protected $profileController;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ProfileController $profileController)
    {
        $this->profileController = $profileController;
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $params = ['user_id' => $event->user_id];
        $this->profileController->create(new Request($params));
    }
}
