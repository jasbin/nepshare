@extends('layouts.app')

@section('content')

        <a class="btn btn-secondary m-3" href="/dashboard" role="button">Back</a>


        <div class="card p-3">
        <img style="width:100%" src="/storage/cover_image/{{$post->cover_image}}" alt="post image">
        <h3><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></h3>
        <p>{!!$post->body!!}</p>
        <small>posted on {{$post->created_at}} by {{$post->user->name}}</small>
        </div>
        @if (!Auth::guest()) {{-- if user is not a guest then show edit and delete button --}}
                @if (Auth::user()->id == $post->user_id)
                        <div><button class="btn"><a class ='float-left' href="{{route('posts.edit', $post->id)}}">Edit</a> </button>
                                {!!Form::open(['action'=>['PostsController@destroy',$post->id], 'method' => 'DELETE','class'=>'float-right']) !!}
                                {{Form::submit('Delete', ['class'=> 'btn btn-danger']) }}
                                {!!Form::close() !!}
                        </div>
                @endif

        @else
            <p>you must be logged in to comment</p>
        @endif

         @if(!Auth::guest())
            <h3 class="mt-3">Comment</h3>
            {!! Form::open(['action' => ['PostsController@comment', $post->id , Auth::user()->name], 'method' => 'POST']) !!}

            <div class="form-group">
            {{Form::label('comment', 'Comment')}}
            {{Form::textarea('comment','{{-- some value--}}', ['class'=>'form-control','rows' => 4, 'placeholder' => 'Comment Here'])}}
            </div>

            {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
            {!! Form::close() !!}
        @endif

        <h3 class="mt-5">Post Comments</h3>
        @if(count($post->comments)>0)
            @foreach($post->comments as $comment)

                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title"><strong>{{$comment->comment_by}}</strong></h5>
                            <p class="card-text">{{$comment->body}}</p>
                            <small>commented on {{$comment->created_at}}</small>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card mb-2">
                <div class="card-body">
                        <p class="card-text"><strong>no any comments</strong></p>
                </div>
            </div>
        @endif

        @endsection

