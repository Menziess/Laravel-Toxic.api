@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">

        <div class="container">
            
            <Editbox></Editbox>

            @if(isset($posts))
            @foreach($posts as $post)
                <Displaybox subject="{{ $post->subject }}"
                    attachment="{{ $post->attachment }}"
                    drawing="{{ $post->drawing }}"
                    text="{{ $post->text }}"
                    url="{{ $post->url }}"
                ></Displaybox>
            @endforeach
            @endif

        </div>

    </div>
</div>
@endsection
