@extends('layouts.app')

@section('content')
    <x-todo-list :todos="$todos" />
@endsection