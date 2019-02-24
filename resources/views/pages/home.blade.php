@extends('layouts.app')

@section('content')


<!-- Jumbotron -->
<div class="jumbotron text-center">
        <!-- Title -->
        <h2 class="card-title h4 pb-2"><strong>JUST SHARE IT</strong></h2>
        <!-- Card image -->
        <div class="view overlay mb-4">
          <img src="https://proxy.duckduckgo.com/iu/?u=https%3A%2F%2Forig00.deviantart.net%2Fef42%2Ff%2F2015%2F341%2Fd%2F6%2Fflat_landscape__winter_edition__by_jovicasmileski-d9jbz70.jpg&f=1" class="img-fluid" alt="">
          <a href="#">
            <div class="mask rgba-white-slight"></div>
          </a>
        </div>

        <h3 class="indigo-text h5 mb-2">A Place To Share Everything</h3>
        <p class="card-text">Start Sharing your thoughts, feelings and memes to the World</p>
      </div>
      <!-- Jumbotron -->
    @if (count($posts)>0)
        @foreach ($posts as $post)

                <div class="card p-3 mb-2 mt-2">  {{--padding by 3 and margin-buttom by 2--}}
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            <img style="width:100%" src="/storage/cover_image/{{$post->cover_image}}" alt="post image">
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h3><a href="{{route('posts.show', $post->id)}}">{{$post->title}}</a></h3>
                            {{-- <p>{!! substr( $post->body, 0, random_int(60, 150)) !!}</p> --}}
                        <p>{!!str_limit($post->body, $limit = 60, $end = '...') !!}
                        </p>
                        <br>
                        <a href="{{route('posts.show', $post->id)}}" class="btn btn-primary btn-sm" role="button">Read More</a><br> 
                            <small>posted on {{$post->created_at}} by {{$post->user->name}}</small>
                        </div>
                    </div>
                </div>
        @endforeach
        {{$posts->links()}}
    @else
        <h3>No Post Found</h3>
    @endif

@endsection
