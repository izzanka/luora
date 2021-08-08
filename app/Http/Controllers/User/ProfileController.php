<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Topic;
use App\Models\Location;
use App\Models\Education;
use App\Models\UserTopic;
use App\Models\Employment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function employment_credential($user){
        $year_or_current = $user->employment->currently ? 'present' : $user->employment->end_year;
        return 
        [
            'credential' => $user->employment->position . ' at ' . $user->employment->company,
            'year' => ' (' . $user->employment->start_year . '-' . $year_or_current . ')'
        ];
    }

    public function education_credential($user){
        $year_or_current = $user->education->graduation_year ? ' (Graduated ' . $user->education->graduation_year . ')' : null;
        return [
            'credential' => $user->education->degree_type . ' in ' . $user->education->primary . ', ' . $user->education->school,
            'year' => $year_or_current,
        ]; 
    }

    public function location_credential($user){
        $year_or_current = $user->location->currently ? 'present' : $user->location->end_year;
        return [
            'credential' => 'Lives in ' . $user->location->location,
            'year' => ' (' . $user->location->start_year . '-' . $year_or_current . ')',
        ]; 
    }

    public function index(User $user)
    {
        $topics = Topic::all();
        $user->load(['employment','education','location']);
        $employment_credential = [];
        $education_credential = [];
        $location_credential = [];

        //check employment credential
        if($user->employment){
            $employment_credential = $this->employment_credential($user);
        }
        //check education credential
        if($user->education){
           $education_credential = $this->education_credential($user);
        }
        //check location credential
        if($user->location){
            $location_credential = $this->location_credential($user);
        }

        return view('user.profile.index',compact('user','topics','employment_credential','education_credential','location_credential'));
    }

    public function update_topics(Request $request,User $user){
    
        $utopics = UserTopic::where('user_id',$user->id)->get();

        foreach($utopics as $utopic){
            $topic = Topic::find($utopic->topic_id);
            $topic->qty -= 1;
            $topic->update();
            $utopic->delete();
        }

        if($request->topic_id){
            for ($i=0; $i < count($request->topic_id); $i++) {
    
                UserTopic::create([
                    'user_id' => $user->id,
                    'topic_id' => $request->topic_id[$i]
                ]);
                
                $topic = Topic::find($request->topic_id[$i]);
                $topic->qty += 1;
                $topic->update();
        
            }
         

            return back()->with('message',['text' => 'Topics updated successfully!', 'class' => 'success']);
        }else{
            return back()->with('message',['text' => 'Topics deleted successfully!', 'class' => 'success']);
        }
       
    }

    public function update_credentials(Request $request,User $user,$credentials){

       if($credentials == "employment"){
         
            $request->validate([
                'position' => 'required|max:60',
                'company' => 'required|max:12',
                'start_year' => 'required|max:4',
                'end_year' => 'max:4',
            ]);

            if($user->employment){
                $user->employment->update([
                    'position' => $request->position,
                    'company' => $request->company,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);
            }else{
                Employment::create([
                    'user_id' => $user->id,
                    'position' => $request->position,
                    'company' => $request->company,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);
            }

        }else if($credentials == "education"){
            
            $request->validate([
                'school' => 'required',
                'primary' => 'required',
                'degree_type' => 'required',
                'graduation_year' => 'max:4'
            ]);

            if($user->education){

                $user->education->update([
                    'school' => $request->school,
                    'primary' => $request->primary,
                    'degree_type' => $request->degree_type,
                    'graduation_year' => $request->graduation_year
                ]);

            }else{
             
                Education::create([
                    'user_id' => $user->id,
                    'school' => $request->school,
                    'primary' => $request->primary,
                    'degree_type' => $request->degree_type,
                    'graduation_year' => $request->graduation_year
                ]);
            }

        }else if($credentials == "location"){
            
            $request->validate([
                'location' => 'required',
                'start_year' => 'required|max:4',
                'end_year' => 'max:4',
            ]);

            if($user->location){

                $user->location->update([
                    'location' => $request->location,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);

            }else{

                Location::create([
                    'user_id' => $user->id,
                    'location' => $request->location,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);

            }
        }

        return back()->with('message',['text' => $credentials . ' credential updated successfully!', 'class' => 'success']);

    }

    public function update_profile(Request $request,User $user,$profile){

        if($profile == "credential"){

            $title = "Credential";

            $user->update([
                'credential' => $request->credential
            ]);

        }else if($profile == "description"){

            $title = "Description";
    
            $user->update([
                'description' => $request->description
            ]);

        }else if($profile == "name"){

            $request->validate([
                'name' => 'required|string',
            ]);

            $title = "Name";
            $name_slug = Str::of($request->name)->slug('-');

            $user->update([
                'name' => $request->name,
                'name_slug' => $name_slug
            ]);

            return redirect()->route('profile.index',$name_slug)->with('message',['text' =>  'Profile ' . $title . ' updated successfully!', 'class' => 'success']);

        }

        return back()->with('message',['text' =>  'Profile ' . $profile . ' updated successfully!', 'class' => 'success']);
    }

    public function destroy_credentials(Request $request,User $user,$credentials){

        if($credentials == "employment"){
            $user->employment->delete();
        }else if($credentials == "education"){
            $user->education->delete();
        }else if($credentials == "location"){
            $user->location->delete();
        }

        return back()->with('message',['text' => $credentials . ' credential deleted successfully!', 'class' => 'success']);
    }

    public function show_topics(User $user){
        $show_topics = $user->topics()->orderBy('qty','desc')->get();
        return response()->json(['data' => $show_topics]);
    }

    public function show_questions(User $user){
        $show_questions = $user->questions()->latest()->get();
        return response()->json(['data' => $show_questions]);
    }

    public function show_answers(User $user){
        $show_answers = $user->answers()->with('question')->latest()->get();
        return response()->json(['data' => $show_answers]);
    }

    public function show(User $user){
        
        $employment_credential = [];
        $education_credential = [];
        $location_credential = [];

        //redirect to profile if want to show logged account
        if($user->id == auth()->id()){
            return redirect()->route('profile.index',auth()->user()->name_slug);
        }

        //check employment credential
        if($user->employment){
            $employment_credential = $this->employment_credential($user);
        }
        //check education credential
        if($user->education){
           $education_credential = $this->education_credential($user);
        }
        //check location credential
        if($user->location){
            $location_credential = $this->location_credential($user);
        }
       
        return view('user.profile.show',compact('user','employment_credential','education_credential','location_credential'));
    }

    public function follow(User $user){
        $authUser = auth()->user();
        
        //check is auth user is following or not
        if($authUser->isFollowing($user)){
            $authUser->unfollow($user);
        }else{
            $authUser->follow($user);
        }
       
        return back();
    }

   


}
