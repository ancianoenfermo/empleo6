<?php

namespace App\View\Components;

use Illuminate\View\Component;

class JobCard2 extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $job;
    public function __construct($job)
    {
     $this->job = $job;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.job-card2');
    }
}
