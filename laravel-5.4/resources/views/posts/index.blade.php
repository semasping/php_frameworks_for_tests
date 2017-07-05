@extends ('layout')

@section ('content')
    <div class="page-header">
        <h1>
            Posts list
        </h1>
    </div>
    <div class="row">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Body</th>
                <th>Slug</th>
                <th>Author</th>
                <th>Post Of Type</th>
                <th>Categories</th>

            </tr>
            </thead>
            <tbody>
            @foreach ( $posts as $post )
                <tr>
                    <td> {{$post->id}} </td>
                    <td> {{$post->title}} </td>
                    <td> {{$post->body}} </td>
                    <td> {{$post->slug}} </td>
                    <td> {{$post->author->name_f_l}}</td>
                    <td> {{$post->postType->name}} </td>
                    <td>
                        @foreach($post->categories as $category)
                            {{$category->name}};
                        @endforeach
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection