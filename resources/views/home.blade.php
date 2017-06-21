@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="container">
            
            <Box></Box>

            @if(isset($posts))
            @foreach($posts as $post)
                <Post id="{{ $post->id }}"
                    slug="{{ $post->slug }}" 
                    subject="{{ $post->subject }}"
                    attachment="{{ $post->attachment }}"
                    drawing="{{ $post->drawing }}"
                    text="{{ $post->text }}"
                    url="{{ $post->url }}"
                ></Post>
            @endforeach
            @endif

        </div>

    </div>
</div>
@endsection
