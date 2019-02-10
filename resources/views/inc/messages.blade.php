@if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                <ul>
                        @foreach ($errors->all() as $error)
                         <li>{{$error}}</li>
                    @endforeach
                </ul>
                
        </div>
    
@endif

@if (session('success'))
    <div class="alert alert-success mt-2" role="alert">
        {{session('success')}}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mt-2">
        {{session('error')}}
    </div>
@endif