<?php

namespace App\Controllers;

use App\Models\Note;

class IndexController
{
    public function __invoke()
    {

        return view('index');
    }
}
