@extends('master')


@section('content')
<h1>Category View</h1>

<div>
    <h4>Category Name: {{ $category->name }}</h3>
    <h4>Category Description: {{ $category->description }}</h3>
    <h4>Category Status: {{ $category->status }}</h3>
</div>


@endsection