@extends('layouts.app')

@section('content')
<div class="container">
    
    @include('user.includes.title')

    <div class="row justify-content-center">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Firstname</th>
                    <th scope="col">Lastname</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Role</th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td scope="row">{{ $user->name }}</td>
                        <td scope="row">{{ $user->firstname }}</td>
                        <td scope="row">{{ $user->lastname }}</td>
                        <td scope="row">{{ $user->email }}</td>
                        <td scope="row">{{ $user->getRoleName() }}</td>
                        <td scope="row" class="actions text-center">
                            <form action="{{ route('user.destroy',$user->id) }}" method="Post">
                                <a href="{{ route('user.edit',$user->id) }}">
                                    <i class="fa-solid fa-pen-to-square fa-lg"></i>
                                </a>
                                <button type="submit" style="border: 0;">
                                    <i class="fa-solid fa-trash-can fa-lg"></i>
                                </button>
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $users->links() !!}
        </div>
    </div>
</div>
@endsection