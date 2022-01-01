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

    //set credential on blade
    public static function set_credential($user){
        if($user->credential){
            return $user->credential;
        }else{
            $user->load(['employment','education','location']);
            if($user->employment){
                $year_or_currently = $user->employment->currently ? 'present' : $user->employment->end_year;
                $year_or_null = $year_or_currently ? ' (' . $user->employment->start_year . ' - ' . $year_or_currently . ')' : ' (' . $user->employment->start_year . ')';
                return $user->employment->position . ' at ' . $user->employment->company . $year_or_null;
            }else{
                if($user->education){
                    $year = $user->education->graduation_year ? ' (Graduated ' . $user->education->graduation_year . ')' : null;
                    return $user->education->degree_type . ' in ' . $user->education->primary . ', ' . $user->education->school . $year;
                }else{
                    if($user->location){
                        $year_or_currently = $user->location->currently ? 'present' : $user->location->end_year;
                        $year_or_null = $year_or_currently ? ' (' . $user->location->start_year . ' - ' . $year_or_currently . ')' : ' (' . $user->location->start_year . ')';

                        return 'Lives in ' . $user->location->location . $year_or_null;
                    }else{
                        return "";
                    }
                }
            }
        }
    }

    //set credential
    public function employment_credential($user){
        $year_or_currently = $user->employment->currently ? 'present' : $user->employment->end_year;
        $year_or_null = $year_or_currently ? ' (' . $user->employment->start_year . ' - ' . $year_or_currently . ')' : ' (' . $user->employment->start_year . ')';

        return [
            'credential' => $user->employment->position . ' at ' . $user->employment->company,
            'year' => $year_or_null,
        ];
    }

    public function education_credential($user){
        $year_or_currently = $user->education->graduation_year ? ' (Graduated ' . $user->education->graduation_year . ')' : null;
        return [
            'credential' => $user->education->degree_type . ' in ' . $user->education->primary . ', ' . $user->education->school,
            'year' => $year_or_currently,
        ]; 
    }

    public function location_credential($user){
        $year_or_currently = $user->location->currently ? 'present' : $user->location->end_year;
        $year_or_null = $year_or_currently ? ' (' . $user->location->start_year . ' - ' . $year_or_currently . ')' : ' (' . $user->location->start_year . ')';

        return [
            'credential' => 'Lives in ' . $user->location->location,
            'year' => $year_or_null,
        ]; 
    }

    public function index(User $user){
        
        $employment_credential = [];
        $education_credential = [];
        $location_credential = [];

        //redirect to show profile
        if($user->id != auth()->id()){
            return redirect()->route('profile.show',$user->name_slug);
        }

        $topics = Topic::select(['id','name','name_slug'])->orderBy('name','asc')->get();
        $user->load(['employment','education','location']);
        
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

        if($user->id != auth()->id()){
            return back();
        }  
    
        $utopics = UserTopic::where('user_id',$user->id)->get();

        foreach($utopics as $utopic){
            $topic = Topic::find($utopic->topic_id);
            $topic->follower -= 1;
            $topic->update();
            $utopic->delete();
        }

        if($request->topic_id){
            $count = 0;
            for ($i=0; $i < count($request->topic_id); $i++) {
                
                $checkTopic = Topic::find($request->topic_id[$i]);
                $count++;
                
                //if added topics more than 8 or topic not found
                if($count > 8 || $checkTopic == null){
                    break;
                }

                UserTopic::create([
                    'user_id' => $user->id,
                    'topic_id' => $request->topic_id[$i]
                ]);
                
                $topic = Topic::find($request->topic_id[$i]);
                $topic->follower += 1;
                $topic->update();
            }

            return back()->with('message',['text' => 'Topics updated successfully!', 'class' => 'success']);
        
        }else{
            return back()->with('message',['text' => 'Topics deleted successfully!', 'class' => 'success']);
        }
       
    }

    public function update_credentials(Request $request,User $user,$credentials){

        if($user->id != auth()->id()){
            return back();
        }   

        if($credentials == "employment"){

            $request->validate([
                'position' => 'required|max:40',
                'company' => 'required|max:20',
                'start_year' => 'required|max:4',
                'end_year' => 'max:4',
            ]);

            $position = ucwords($request->position);
            $company = ucwords($request->company);

            if($user->employment){

                $user->employment->update([
                    'position' => $position,
                    'company' => $company,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);

            }else{

                Employment::create([
                    'user_id' => $user->id,
                    'position' => $position,
                    'company' => $company,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);
            }

        }else if($credentials == "education"){
            
            $request->validate([
                'school' => 'required|max:40',
                'primary' => 'required|max:40',
                'degree_type' => 'required|max:40',
                'graduation_year' => 'max:4'
            ]);

            $school = ucwords($request->school);
            $primary = ucwords($request->primary);
            $degree_type = ucwords($request->degree_type);

            if($user->education){

                $user->education->update([
                    'school' => $school,
                    'primary' => $primary,
                    'degree_type' => $degree_type,
                    'graduation_year' => $request->graduation_year
                ]);

            }else{
             
                Education::create([
                    'user_id' => $user->id,
                    'school' => $school,
                    'primary' => $primary,
                    'degree_type' => $degree_type,
                    'graduation_year' => $request->graduation_year
                ]);
            }

        }else if($credentials == "location"){
            
            $request->validate([
                'location' => 'required|max:40',
                'start_year' => 'required|max:4',
                'end_year' => 'max:4',
            ]);

            $location_name = ucwords($request->location);

            if($request->end_year != null){
                if($request->end_year >= $request->start_year){

                }else{
                    return back()->with('message',['text' => ' The end year location credential is invalid!', 'class' => 'danger']);
                }
            }
            
            if($user->location){

                $user->location->update([
                    'location' => $location_name,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);

            }else{

                Location::create([
                    'user_id' => $user->id,
                    'location' => $location_name,
                    'start_year' => $request->start_year,
                    'end_year' => $request->end_year,
                    'currently' => $request->currently
                ]);

            }
        }else{
            return back();
        }

        return back()->with('message',['text' => ucfirst($credentials) . ' credential updated successfully!', 'class' => 'success']);
    }

    public function update_profile(Request $request,User $user,$profile){

        if($user->id != auth()->id()){
            return back();
        }  

        if($profile == "credential"){

            $user->update([
                'credential' => $request->credential
            ]);

        }else if($profile == "description"){
    
            $user->update([
                'description' => $request->description
            ]);

        }else if($profile == "name"){

            $request->validate([
                'name' => 'required|string',
            ]);

            $name_slug = Str::of($request->name)->slug('-');

            $user->update([
                'name' => $request->name,
                'name_slug' => $name_slug
            ]);

            //has own redirect because name slug
            return redirect()->route('profile.index',$name_slug)->with('message',['text' =>  'Profile ' . '(' .  $profile . ')' . ' updated successfully!', 'class' => 'success']);
        
        }else{
            return back();
        }

        return back()->with('message',['text' =>  'Profile ' . '(' . $profile . ')' . ' updated successfully!', 'class' => 'success']);
    }

    public function destroy_credentials(Request $request,User $user,$credentials){

        if($user->id != auth()->id()){
            return back();
        }  

        if($credentials == "employment"){
            $user->employment->delete();
        }else if($credentials == "education"){
            $user->education->delete();
        }else if($credentials == "location"){
            $user->location->delete();
        }else{
            return back();
        }

        return back()->with('message',['text' => ucfirst($credentials) . ' credential deleted successfully!', 'class' => 'success']);
    }

    public function show(User $user){
        
        $employment_credential = [];
        $education_credential = [];
        $location_credential = [];

        //redirect to profile if want to show current user
        if($user->id == auth()->id()){
            return redirect()->route('profile.index',auth()->user()->name_slug);
        }

        $user->load(['employment','education','location']);
        
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
        
        //check if current user is following or not
        if($authUser->isFollowing($user)){
            $authUser->unfollow($user);
        }else{
            $authUser->follow($user);
        }
       
        return back();
    }

    //api show user contents
    public function show_topics(User $user){
        $topics = $user->topics()->orderBy('follower','desc')->get();
        return response()->json(['data' => $topics]);
    }

    public function show_questions(User $user){
        $questions = $user->questions()->latest()->get();
        return response()->json(['data' => $questions]);
    }

    public function show_answers(User $user){
        $answers = $user->answers()->with('question')->latest()->get();
        return response()->json(['data' => $answers]);
    }

}
