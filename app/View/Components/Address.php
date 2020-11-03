<?php

namespace App\View\Components;

use App\Country;
use Illuminate\View\Component;

class Address extends Component
{
    public $countries;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->countries = Country::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.address');
    }
}
