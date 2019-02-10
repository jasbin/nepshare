@extends('layouts.app')

@section('content')

        <a class="btn btn-secondary m-3" href="/dashboard" role="button">Back</a>


        <div class="card p-3">
        <img style="width:100%" src="/storage/cover_image/{{$post->cover_image}}" alt="post image">
        <h3><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></h3>
        <p>{!!$post->body!!}</p>
        <small>posted on {{$post->created_at}} by {{$post->user->name}}</small>
        
        @if (!Auth::guest()) {{-- if user is not a guest then show edit and delete button --}}
                @if (Auth::user()->id == $post->user_id)
                        <div><button class="btn"><a class ='float-left' href="{{route('posts.edit', $post->id)}}">Edit</a></button>
                        
                                {!!Form::open(['action'=>['PostsController@destroy',$post->id], 'method' => 'DELETE','class'=>'float-right']) !!}
                                {{Form::submit('Delete', ['class'=> 'btn btn-danger']) }}
                                {!!Form::close() !!}
                        </div>
                @endif
        @endif
        
        @endsection