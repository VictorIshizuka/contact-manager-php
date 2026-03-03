<?php

namespace App\Middlewares;

class GuestMiddleware
{
    public function handle()
    {
        if (auth()) {
            redirect('/notes');
        }
    }
}
