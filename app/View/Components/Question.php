<?php

namespace App\View\Components;

use App\Models\Topic;
use Illuminate\View\Component;

class Question extends Component
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
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $topics = Topic::orderBy('name','asc')->get();
        return view('components.question',compact('topics'));
    }
}
