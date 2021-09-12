<?php

namespace App\View\Components;

use App\Models\Answer;
use Illuminate\View\Component;

class AdminAnswers extends Component
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
        $answers = Answer::whereNull('status')->orWhere('status','updated_by_user')->orWhereHas('report_users')->count();
        return view('components.admin-answers',compact('answers'));
    }
}
