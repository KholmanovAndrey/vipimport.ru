<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Dashboard extends Component
{
    public $title;
    public $breadcrumbs;

    /**
     * Dashboard constructor.
     * @param $title
     * @param $breadcrumbs
     */
    public function __construct($title, $breadcrumbs)
    {
        $this->title = $title;
        $this->breadcrumbs = $breadcrumbs;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.dashboard');
    }
}
