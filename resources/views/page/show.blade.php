@extends('admin.master')
@section('title')
    Pages
@endsection

@section('content')
    <default-container>
        <page-show :items="{{json_encode($items)}}" :options="{{json_encode($options)}}" />
    </default-container>
@endsection
