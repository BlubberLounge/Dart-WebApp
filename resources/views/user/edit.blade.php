@extends('layouts.app')

@section('content')
<div class="container">
    
    @include('user.includes.title')
    
    @include('user.includes.form', ['action' => 'edit'])

</div>
@endsection