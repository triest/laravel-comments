@extends('layouts.comments',['title'=>'Коментарии'])

@section('content')
    <div class="col md-4">
        @if(isset(Auth::user()->id))
            <comment-app :user="{{Auth::user()->id}}"></comment-app>
        @else
            <comment-app></comment-app>
        @endauth
    </div>
@endsection
