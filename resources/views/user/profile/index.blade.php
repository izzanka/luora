@extends('layouts.app')

@section('title')
{{ $user->name }} - Luora
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-8">
            @include('layouts.success')
      
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-2">
                            <img src="{{ $user->avatar }}" alt="avatar" class="rounded-circle mr-2" width="100px" height="100px">
                        </div>
                        <div class="col-sm-9">
                            <b style="font-size: 25px" id="name">{{ $user->name }} </b><small id="btneditName"><a href="" class="text-secondary" data-toggle="modal" data-target="#nameModal">Edit</a></small><br>
                            <a href="" class="text-secondary" data-toggle="modal" data-target="#profileModal">{{ $user->credential ?? 'Add profile credential' }}</a>
                        </div>

                        <!-- Modal Edit Profile Name -->
                        <form action="{{ route('profile.update',['user' => $user->name_slug,'profile' => 'name']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal fade" id="nameModal" tabindex="-1" aria-labelledby="nameModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="nameModalLabel">Edit profile name</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                                @include('layouts.error', ['name' => 'name'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>

                        <!-- Modal Edit Profile Credential-->
                        <form action="{{ route('profile.update',['user' => $user->name_slug,'profile' => 'credential']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="profileModalLabel">Edit profile credentials</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="credential" cols="10" rows="7" class="form-control" placeholder="librarian in New York, reads constanty (50)">{{ $user->credential }}</textarea>    
                                                @include('layouts.error', ['name' => 'credential'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <a href="" class="text-secondary" data-toggle="modal" data-target="#descModal">{{ $user->description ?? 'Write a description about yourself' }}</a>
                        </div>

                         <!-- Modal Edit Profile Description -->
                         <form action="{{ route('profile.update',['user' => $user->name_slug,'profile' => 'description']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal fade" id="descModal" tabindex="-1" aria-labelledby="descModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="descModalLabel">Edit description</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <textarea name="description" cols="10" rows="7" class="form-control" placeholder="">{{ $user->description }}</textarea>    
                                                @include('layouts.error', ['name' => 'description'])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-2">
                            {{ $user->answers->count() ?? 0}} Answers
                        </div>
                        <div class="col-sm-2">
                            {{ $user->questions->count() ?? 0}} Questions
                        </div>
                        <div class="col-sm-2">
                            0 Shares
                        </div>
                        <div class="col-sm-2">
                            0 Followers
                        </div>
                        <div class="col-sm-2">
                            0 Following
                        </div>
                        <div class="col-sm-2">
                            0 Activity
                        </div>
                    </div>
                    <hr>
                </div>
        </div>
        <div class="col-4">
            <div class="mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            Credentials & Highlights
                            <i class="bi bi-pencil-square text-dark float-right"></i>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <i class="bi bi-briefcase mr-2" style="font-size: 15px"></i>
                            @if ($employment_credential)
                                <span class="text-dark"> {{ $employment_credential['credential'] }} <small class="text-secondary">{{  $employment_credential['year']}}</small></span>
                            @else
                                <a href="" data-toggle="modal" data-target="#employmentModal"> Add employment credential</a>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Modal Edit Employment Credential-->
                    <form action="{{ route('profile.credentials', ['user' => $user->name_slug,'credentials' => 'employment']) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal fade" id="employmentModal" tabindex="-1" aria-labelledby="employmentModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="employmentModalLabel">Edit employment credential</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <label for="">Position</label>
                                                            <input type="text" name="position" class="form-control" value="{{ $user->employment->position ?? '' }}">
                                                            @include('layouts.error', ['name' => 'position'])
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <label for="">Company / Organization</label>
                                                            <input type="text" name="company" class="form-control" value="{{ $user->employment->company ?? '' }}">
                                                            @include('layouts.error', ['name' => 'company'])
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-12">
                                                            <label for="">Start Year</label>
                                                            <select name="start_year" id="startyear-dropdown" class="form-control" >
                                                                @if ($user->employment->start_year ?? '')
                                                                    <option value="{{ $user->employment->start_year }}" selected>
                                                                    {{ $user->employment->start_year }}</option>
                                                                    <option value="">----</option>
                                                                @endif
                                                               
                                                            </select>
                                                            @include('layouts.error', ['name' => 'start_year'])
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2" id="endyear">
                                                        <div class="col-12">
                                                            <label for="">End Year</label>
                                                            <select name="end_year" id="endyear-dropdown" class="form-control">
                                                                @if($user->employment->end_year ?? '')
                                                                <option value="{{ $user->employment->end_year }}" 
                                                                    selected>
                                                                    {{ $user->employment->end_year}}</option>
                                                                <option value="">----</option>
                                                                @else
                                                                    <option value="" selected>----</option>
                                                                @endif
                                                            </select>
                                                            @include('layouts.error', ['name' => 'end_year'])
                                                        </div>
                                                    </div>
                                                    <div class="row mt-4">
                                                        <div class="col-12">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" value="1" name="currently" id="currently" 
                                                                @if ($user->employment->currently ?? '')
                                                                    @if ($user->employment->currently == true)
                                                                        {{ 'checked' }}
                                                                    @else
                                                                    
                                                                    @endif>
                                                                @endif
                           
                                                                <label class="form-check-label">
                                                                  I currently work here
                                                                </label>
                                                              </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                            </div>
                        </div>
                    </form>

                    <div class="row mt-2">
                        <div class="col-12">
                            <i class="bi bi-book mr-2" style="font-size: 15px"></i>
                            @if ($education_credential)
                                <span class="text-dark"> {{ $education_credential['credential'] }} <small class="text-secondary">{{  $education_credential['year']}}</small></span>
                            @else
                                <a href="" data-toggle="modal" data-target="#educationModal"> Add education credential</a>
                            @endif
                        </div>

                        <!-- Modal Edit Education Credential -->
                        <form action="{{ route('profile.credentials',['user' => $user->name_slug, 'credentials' => 'education']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal fade" id="educationModal" tabindex="-1" aria-labelledby="educationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="educationModalLabel">Edit education credential</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="">School</label>
                                                        <input type="text" name="school" value="{{ $user->education->school ?? '' }}" class="form-control">
                                                        @include('layouts.error', ['name' => 'school'])
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <label for="">Primary</label>
                                                        <input type="text" name="primary" value="{{ $user->education->primary ?? '' }}" class="form-control">
                                                        @include('layouts.error', ['name' => 'primary'])
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <label for="">Degree Type</label>
                                                        <input type="text" name="degree_type" value="{{ $user->education->degree_type ?? '' }}" class="form-control">
                                                        @include('layouts.error', ['name' => 'degree_type'])
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <label for="">Graduation Year</label>
                                                        <select name="graduation_year" id="gradyear-dropdown" class="form-control">
                                                            @if($user->education->graduation_year ?? '')
                                                            <option value="{{ $user->education->graduation_year }}" 
                                                                selected>
                                                                {{ $user->education->graduation_year}}</option>
                                                            <option value="" disabled>----</option>
                                                            @else
                                                                <option value="" selected>----</option>
                                                            @endif
                                                        </select>
                                                        @include('layouts.error', ['name' => 'graduation_year'])
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <i class="bi bi-geo-alt mr-2" style="font-size: 15px"></i>
                            @if ($location_credential)
                                <span class="text-dark"> {{ $location_credential['credential'] }} <small class="text-secondary">{{  $location_credential['year']}}</small></span>
                            @else
                                <a href="" data-toggle="modal" data-target="#locationModal"> Add location credential</a>
                            @endif
                        </div>

                        <!-- Modal Edit Location Credential -->
                        <form action="{{ route('profile.credentials',['user' => $user->name_slug,'credentials' => 'location']) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="locationModalLabel">Edit location credential </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="">Location</label>
                                                        <input type="text" name="location" class="form-control" value="{{ $user->location->location ?? '' }}">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-12">
                                                        <label for="">Start Year</label>
                                                        <select name="start_year" id="startyear-dropdown2" class="form-control" >
                                                            @if ($user->location->start_year ?? '')
                                                                <option value="{{ $user->location->start_year }}" selected>
                                                                {{ $user->location->start_year }}</option>
                                                                <option value="" disabled>----</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-2" id="endyear2">
                                                    <div class="col-12">
                                                        <label for="">End Year</label>
                                                        <select name="end_year" id="endyear-dropdown2" class="form-control">
                                                            @if($user->location->end_year ?? '')
                                                            <option value="{{ $user->location->end_year }}" 
                                                                selected>
                                                                {{ $user->location->end_year}}</option>
                                                            <option value="" disabled>----</option>
                                                            @else
                                                                <option value="" selected>----</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mt-4">
                                                    <div class="col-12">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="1" name="currently" id="currently2" 
                                                            @if ($user->location->currently ?? '')
                                                                @if ($user->location->currently == true)
                                                                    {{ 'checked' }}
                                                                @else
                                                                
                                                                @endif>
                                                            @endif
                       
                                                            <label class="form-check-label">
                                                              I currently live here
                                                            </label>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <i class="bi bi-calendar mr-2" style="font-size: 15px"></i> Joined {{ $user->created_at->format('M Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Knows about
                    <a href="" class="text-dark float-right" data-toggle="modal" data-target="#topicModal"><i class="bi bi-pencil-square"></i></a>
                    <!-- Modal Add Topics-->
                    <form action="{{ route('profile.topics',$user->name_slug) }}" method="POST">
                        @csrf
                        @method('PUT')
                            <div class="modal fade" id="topicModal" tabindex="-1" aria-labelledby="topicModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="topicModalLabel">Add topics</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        Topics : 
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach ($topics as $topic)
                                                            <div class="col-sm-3">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="{{ $topic->id }}" name="topic_id[]" @php
                                                                    $checked = "";
                                                                    foreach($user->topics as $utopic){
                                                                        if($utopic->name == $topic->name){
                                                                            $checked = "checked";
                                                                        }
                                                                    }
                                                                @endphp 
                                                                {{ $checked }}>
                                                                    <label class="form-check-label" for="defaultCheck1">
                                                                    {{ $topic->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @endforeach  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>     
                                    </div>  
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <hr>
                <div class="container">
                    <div class="row">
                        @forelse ($user->topics as $topic)
                            <div class="col-sm-6">
                                <li><b><a href="" class="text-dark">{{ $topic->name }}</a></b></li>
                            </div>
                        @empty
                        <div class="row">
                            <div class="col-sm-12">
                                You haven't added any topics yet.
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
                    
            </div>
           
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    //script for hide & show button edit profile name
    $("#btneditName").hide();
    $("#name").mouseenter(function(){
        $("#btneditName").show();
    });
    $("#btneditName").mouseleave(function(){
        $("#btneditName").hide();
    });

    //script for currently checkbox
    if($("#currently").prop("checked") == true){
        $("#endyear").hide();
    }
    if($("#currently2").prop("checked") == true){
        $("#endyear2").hide();
    }
    $("#currently").on('click',function(){
      if($(this).prop("checked") == true){
          $("#endyear").hide();
      }else if($(this).prop("checked") == false){
          $("#endyear").show();
      }
    });
    $("#currently2").on('click',function(){
      if($(this).prop("checked") == true){
          $("#endyear2").hide();
      }else if($(this).prop("checked") == false){
          $("#endyear2").show();
      }
    });

    //script for show years in dropdown
    let startyearDropdown = document.getElementById('startyear-dropdown');
    let endyearDropdown = document.getElementById('endyear-dropdown');
    let startyearDropdown2 = document.getElementById('startyear-dropdown2');
    let endyearDropdown2 = document.getElementById('endyear-dropdown2');
    let gradyearDropdown = document.getElementById('gradyear-dropdown');

    yeardropdown(startyearDropdown);
    yeardropdown(endyearDropdown);
    yeardropdown(startyearDropdown2);
    yeardropdown(endyearDropdown2);
    yeardropdown(gradyearDropdown);

    function yeardropdown(dropdown){
        let currentYear = new Date().getFullYear();    
        let earliestYear = 2000;     
        while (currentYear >= earliestYear) {      
            let dateOption = document.createElement('option');          
            dateOption.text = currentYear;      
            dateOption.value = currentYear;        
            dropdown.add(dateOption);      
            currentYear -= 1;    
        }
    }
 

    
</script>
@endsection