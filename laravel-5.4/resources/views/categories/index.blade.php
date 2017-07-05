@extends ('layout')


@section ('content')
    <div class="page-header">
        <h1>
            Categories list
        </h1>
    </div>
    <div class="row">
        <ul>
		    @foreach ( $categories as $category )
            <li><pre>id: {{$category->id}} &#09; Name:{{$category->name }} &#09; CountPosts: {{$category->posts_count}}</pre></li>
		    @endforeach
        </ul>
    </div>
@endsection