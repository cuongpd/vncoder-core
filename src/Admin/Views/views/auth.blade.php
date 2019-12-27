@extends('admin::layouts.auth')

@section('content')
    @includeIf($auth_template)
@endsection