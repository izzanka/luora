@extends('layouts.app')

@section('title')
Topics
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-2">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Sorted by
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('admin.topics.latest') }}" class="{{ request()->route()->named('admin.topics.latest') ? 'text-danger' : 'text-dark' }}">Latest</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-10">
            
            @include('layouts.success')
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        Topics sorted by latest
                    </div>
                </div>
                <hr>
                @forelse ($topics as $topic)
                    <div class="card mt-2">
                        <div class="card-body">
                            <b>{{ $topic->name }}</b>
                            <span class="float-right">  
                                <a href="{{ route('admin.topic.status',['topic' => $topic->id,'status' => 'deleted_by_admin']) }}" onclick="return confirm('Are you sure?')"><i class="bi bi-x-circle text-danger"></i></a>
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-center mt-2">
                        No Topics
                    </div>
                @endforelse
            </div>
        </div>
     
    </div>
</div>
@endsection
