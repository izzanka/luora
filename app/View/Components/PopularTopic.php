<?php

namespace App\View\Components;

use App\Models\Topic;
use Illuminate\View\Component;

class PopularTopic extends Component
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
        $topics = Topic::select(['name','name_slug','follower'])->orderBy('follower','desc')->take(8)->get();
        return view('components.popular-topic',compact('topics'));
    }
}
