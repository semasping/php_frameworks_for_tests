@extends ('layout')


@section ('content')
    <div class="page-header">
        <h1>
            Authors list
        </h1>
    </div>
    <div class="row">
        <ul>
		    @foreach ( $authors as $author )
            <li><pre>id: {{$author->id}} &#09; Name:{{$author->name_f_l }} &#09; CountPosts: {{$author->posts_count}}</pre></li>
		    @endforeach
        </ul>
    </div>
@endsection