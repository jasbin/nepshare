@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

                <div class="card-header bg-danger text-white">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{route('posts.create')}}" class="btn btn-primary">Create Post</a>
                    <h3 class="mt-2">Your Blog Posts</h3>


                    @if (count($posts)>0)
                    <table class="table table-striped">
                            <tr class="bg-danger text-white">
                                <th>Post Title</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td>{{$post->body}}</td>
                                    <td><a href="{{route('posts.edit', $post->id)}}" class="btn btn-outline-primary">Edit</a></td>
                                    <td>
                                            {!!Form::open(['action'=>['PostsController@destroy',$post->id], 'method' => 'DELETE','class'=>'float-right']) !!}
                                            {{Form::submit('Delete', ['class'=> 'btn btn-danger']) }}
                                            {!!Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <h3>No post Found</h3>
                    @endif

                </div>

        </div>
    </div>
</div>
@endsection
