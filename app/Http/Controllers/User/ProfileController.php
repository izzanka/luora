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
    
    public function index(User $user)
    {
        $topics = Topic::all();
        $user->load(['employment','education','location']);
        $employment_credential = [];
        $education_credential = [];
        $location_credential = [];

        if($user->employment){
            $end = $user->employment->currently ? 'present' : $user->employment->end_year;
            $employment_credential = [
                'credential' => $user->employment->position . ' at ' . $user->employment->company,
                'year' => ' (' . $user->employment->start_year . '-' . $end . ')'
            ];
        }
        if($user->education){
            $end2 = $user->education->graduation_year ? ' (Graduated ' . $user->education->graduation_year . ')' : null;
            $education_credential =[
                'credential' => $user->education->degree_type . ' in ' . $user->education->primary . ', ' . $user->education->school,
                'year' => $end2,
            ]; 
        }
        if($user->location){
            $end3 = $user->location->currently ? 'present' : $user->location->end_year;
            $location_credential = [
                'credential' => 'Lives in ' . $user->location->location,
                'year' => ' (' . $user->location->start_year . '-' . $end3 . ')',
            ]; 
        }
       
        return view('user.profile.index',compact('user','topics','employment_credential','education_credential','location_credential'));
    }

    public function update_topics(Request $request,User $user){

        $utopics = UserTopic::where('user_id',$user->id)->get();
            
        foreach($utopics as $utopic){
            $utopic->delete();
        }

        for ($i=0; $i < count($request->topic_id); $i++) {

            UserTopic::create([
                'user_id' => $user->id,
                'topic_id' => $request->topic_id[$i]
            ]);
           
        }

        return back()->with('message',['text' => 'Topics updated successfully!', 'class' => 'success']);
    }

    public function update_credentials(Request $request,User $user,$credentials){

       if($credentials == "employment"){
         
            $title = "Employment";
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
            $title = "Education";
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
            $title = "Location";
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

        return back()->with('message',['text' => $title . ' credential updated successfully!', 'class' => 'success']);

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

        return back()->with('message',['text' =>  'Profile ' . $title . ' updated successfully!', 'class' => 'success']);
    }

    public function show(User $user){

        if($user->id == auth()->id()){
            return redirect()->route('profile.index',auth()->user()->name_slug);
        }

        $employment_credential = [];
        $education_credential = [];
        $location_credential = [];

        if($user->employment){
            $end = $user->employment->currently ? 'present' : $user->employment->end_year;
            $employment_credential = [
                'credential' => $user->employment->position . ' at ' . $user->employment->company,
                'year' => ' (' . $user->employment->start_year . '-' . $end . ')'
            ];
        }
        if($user->education){
            $end2 = $user->education->graduation_year ? ' (Graduated ' . $user->education->graduation_year . ')' : null;
            $education_credential =[
                'credential' => $user->education->degree_type . ' in ' . $user->education->primary . ', ' . $user->education->school,
                'year' => $end2,
            ]; 
        }
        if($user->location){
            $end3 = $user->location->currently ? 'present' : $user->location->end_year;
            $location_credential = [
                'credential' => 'Lives in ' . $user->location->location,
                'year' => ' (' . $user->location->start_year . '-' . $end3 . ')',
            ]; 
        }
       
        return view('user.profile.show',compact('user','employment_credential','education_credential','location_credential'));
    }

    public function follow(User $user){
        $authUser = auth()->user();
        
        if($authUser->isFollowing($user)){
            $authUser->unfollow($user);
        }else{
            $authUser->follow($user);
        }
       
        return back();
    }


}
