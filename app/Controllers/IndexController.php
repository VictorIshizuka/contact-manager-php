<?php

namespace App\Controllers;

use App\Models\Contact;

class IndexController
{
    public function __invoke()
    {

        $search = request()->get('search');
        $letter = request()->get('letter');

        $contacts = Contact::all($search, $letter);

        return view('index', compact('contacts'));
    }
}
