@extends('admin.master')
@section('title')
@endsection

@section('content')
    <default-container>
        <page-form :options="{{ json_encode($options) }}"/>
    </default-container>
@endsection
