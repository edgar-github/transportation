<?php

namespace App\Observers;

use App\Mail\OrderCrateMail;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        if ((int) $order->company_id === Role::ADMIN) {
            $email = $order->driver->email;
        } else {
            $email = env('ADMIN_EMAIL');
        }

        Mail::to($email)->queue(new OrderCrateMail($order));
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        Log::info($order->company_id);
        if ((int) $order->company_id === Role::ADMIN) {
            $email = $order->driver->email;
            Mail::to($email)->queue(new OrderCrateMail($order));
        }

    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
