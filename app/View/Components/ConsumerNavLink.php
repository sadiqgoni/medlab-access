<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ConsumerNavLink extends Component
{
    /**
     * The URL the link points to.
     *
     * @var string
     */
    public $href;

    /**
     * Whether the link is active.
     *
     * @var bool
     */
    public $active;

    /**
     * Create a new component instance.
     *
     * @param  string  $href
     * @param  bool  $active
     * @return void
     */
    public function __construct($href, $active = false)
    {
        $this->href = $href;
        $this->active = $active;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.consumer-nav-link');
    }
}
