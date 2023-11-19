<?php

namespace App\Livewire\User;

use App\Models\Answer;
use App\Models\Comment;
use App\Models\Share;
use App\Models\View;
use App\Models\Vote;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Stat extends Component
{
    public array $labels = [];
    public array $views = [];
    public array $comments = [];
    public array $upvotes = [];
    public array $shares = [];
    public string $sortBy = "Last 7 days";

    public function mount()
    {

    }

    public function lastDays()
    {
        $last_date = Carbon::today()->subDays(6);
        $dates = CarbonPeriod::create(now()->subDays(6), now());
        $answers = Answer::where('user_id', auth()->id())->where('created_at', '>=', $last_date->format('Y-m-d'))->get();

        foreach($dates as $date)
        {
            $date_format = $date->format('Y-m-d');

            $views_count = 0;
            $comments_count = 0;
            $upvotes_count = 0;
            $shares_count = 0;

            foreach($answers as $answer)
            {
                $views_count += View::where('viewable_id', $answer->id)->whereDate('viewed_at', $date_format)->count();
                $comments_count += Comment::where('answer_id', $answer->id)->whereDate('created_at', $date_format)->count();
                $upvotes_count += Vote::where('answer_id', $answer->id)->where('vote', 'up')->whereDate('created_at', $date_format)->count();
                $shares_count += Share::where('answer_id', $answer->id)->whereDate('shared_at', $date_format)->count();
            }

            $this->labels[] =  $date->format('M d, Y');

            $this->views[] = $views_count;
            $this->comments[] = $comments_count;
            $this->upvotes[] = $upvotes_count;
            $this->shares[] = $shares_count;
        }
    }

    public function allTime()
    {
        $answers = Answer::where('user_id', auth()->id())->get();

        $views_count = 0;
        $comments_count = 0;
        $upvotes_count = 0;
        $shares_count = 0;

        foreach($answers as $answer)
        {
           $views_count += View::where('viewable_id', $answer->id)->count();
           $comments_count += Comment::where('answer_id', $answer->id)->count();
           $upvotes_count += $answer->total_upvotes;
           $shares_count += $answer->total_shares;
        }

        $this->views[] = $views_count;
        $this->comments[] = $comments_count;
        $this->upvotes[] = $upvotes_count;
        $this->shares[] = $shares_count;
    }

    public function sort()
    {
        $this->sortBy == 'Last 7 days' ? $this->sortBy = 'All time' : $this->sortBy = 'Last 7 days';
        $this->render();
    }

    public function render()
    {
        if($this->sortBy == 'Last 7 days'){
            $this->lastDays();
        }else if($this->sortBy == 'All time'){
            $this->allTime();
        }
        return view('livewire.user.stat');
    }
}
