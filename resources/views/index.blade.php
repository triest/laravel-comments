@extends('layouts.comments',['title'=>'Коментарии'])

@section('content')
    <div class="col md-4">
        <comment-app :user="{{Auth::user()->id}}"></comment-app>
    </div>
@endsection
