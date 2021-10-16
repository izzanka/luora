<?php

namespace App\View\Components;

use App\Models\Comment;
use Illuminate\View\Component;

class AdminComments extends Component
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
        $comments = Comment::whereNull('status')->orWhere('status','updated_by_user')->orWhereHas('report_users')->count();
        return view('components.admin-comments',compact('comments'));
    }
}
