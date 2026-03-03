<?php

namespace App\Controllers;

use App\Models\Contact;
use App\Models\Note;

class IndexController
{
    public function __invoke()
    {

        $contacts = Contact::all();
        return view('index', compact('contacts'));
    }
}
