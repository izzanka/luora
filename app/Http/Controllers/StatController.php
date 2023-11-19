<?php

namespace App\Http\Controllers;
use App\Models\Answer;
use App\Models\AnswerVote;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Share;
use App\Models\View;
use App\Models\Vote;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index(Request $request)
    {
        if($request->sort == 'all'){

            $answers = Answer::where('user_id', auth()->id())->get();
            $labels = ['Views','Upvotes','Comments','Shares'];

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

            $views = $views_count;
            $comments = $comments_count;
            $upvotes = $upvotes_count;
            $shares = $shares_count;

            $sort = 'all';
            $sortBy = 'All time';

        }else{

            $last_date = Carbon::today()->subDays(6);
            $dates = CarbonPeriod::create(now()->subDays(6), now());
            $answers = Answer::where('user_id', auth()->id())->where('created_at', '>=', $last_date->format('Y-m-d'))->get();

            $labels = [];
            $views = [];
            $comments = [];
            $upvotes = [];
            $shares = [];


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

                $labels[] =  $date->format('M d, Y');

                $views[] = $views_count;
                $comments[] = $comments_count;
                $upvotes[] = $upvotes_count;
                $shares[] = $shares_count;
            }

            $sort = 'day';
            $sortBy = 'Last 7 days';

        }

        return view('livewire.user.stat', compact('sort','labels','views','comments','upvotes', 'shares', 'sortBy'));
    }

}
