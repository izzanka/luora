<?php

namespace App\Http\Controllers;
use App\Models\Answer;

class StatController extends Controller
{
    // public function index()
    // {
    //     $total_views = Answer::where('user_id', auth()->id())->sum('total_views');
    //     $total_upvotes = Answer::where('user_id', auth()->id())->sum('total_upvotes');
    //     $total_shares = Answer::where('user_id', auth()->id())->sum('total_shares');
    //     $answers = Answer::where('user_id', auth()->id())->withCount('comments')->get();

    //     $comments['Comments'] = 0;

    //     foreach($answers as $answer)
    //     {
    //         $comments['Comments'] += $answer->comments_count;
    //     }

    //     $views['Views'] = $total_views;
    //     $upvotes['Upvotes'] = $total_upvotes;
    //     $shares['Shares'] = $total_shares;

    //     $answers = Answer::select('total_views')->where('user_id',auth()->id())->take(7)->pluck('total_views')->toArray();
    //     $answers_date = Answer::select('created_at')->where('user_id',auth()->id())->take(7)->pluck('created_at')->toArray();

    //     $labels = [];
    //     foreach($answers_date as $date)
    //     {
    //         $labels[] = $date->format("M d, Y");
    //     }

    //     return view('livewire.user.stat', compact('views','upvotes','comments','shares','answers','labels'));
    // }
}
