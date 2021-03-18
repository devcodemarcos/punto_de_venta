<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Breadcrumb extends Component
{
    public Array $breads;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Array $breads)
    {
        $this->breads = $breads;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.breadcrumb');
    }
}
