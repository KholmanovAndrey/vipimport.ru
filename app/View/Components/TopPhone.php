<?php

namespace App\View\Components;

use App\Contact;
use Illuminate\View\Component;

class TopPhone extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $contacts = Contact::query()->where('isPrivate', '=', false)->get();
        return view('components.top-phone', [
            'contacts' => $contacts
        ]);
    }
}
