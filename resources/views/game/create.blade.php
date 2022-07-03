@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row pb-5 pt-2">
        <h3>
            Create a Game
        </h3>
    </div>

    <form action="{{ route('game.store') }}" method="POST" id="gameForm" autocomplete="off">
        <div class="row d-flex justify-content-center p-2 mb-5 g-5">
            <div class="col-6">
                <div class="well">
                    <div class="well-header">
                        Gamemode
                    </div>
                    <div class="btn-toolbar" role="toolbar">
                        <div class="btn-group me-5 mb-3" role="group">
                            <button type="button" class="btn btn-secondary px-4" disabled> X01 </button>

                            <input type="radio" class="btn-check" name="gamemode" id="btnGM301" value="301">
                            <label class="btn btn-outline-primary" for="btnGM301"> 301 </label>

                            <input type="radio" class="btn-check" name="gamemode" id="btnGM401" value="401" checked>
                            <label class="btn btn-outline-primary" for="btnGM401"> 401 </label>

                            <input type="radio" class="btn-check" name="gamemode" id="btnGM501" value="501">
                            <label class="btn btn-outline-primary" for="btnGM501"> 501 </label>

                            <input type="radio" class="btn-check" name="gamemode" id="btnGM601" value="601">
                            <label class="btn btn-outline-primary" for="btnGM601"> 601 </label>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-secondary px-4" disabled> other </button>

                            <input type="radio" class="btn-check" name="gamemode" id="btnGMATC" value="ATC" disabled>
                            <label class="btn btn-outline-primary" for="btnGMATC"> Around-The-Clock </label>

                            <input type="radio" class="btn-check" name="gamemode" id="btnGMGolf" value="Golf" disabled>
                            <label class="btn btn-outline-primary" for="btnGMGolf"> Golf </label>

                            <input type="radio" class="btn-check" name="gamemode" id="btnGMTTT" value="TTT" disabled>
                            <label class="btn btn-outline-primary" for="btnGMTTT"> Tic-Tac-Toe </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="well">
                    <div class="well-header">
                        Dartboard
                    </div>
                    <div class="row d-flex justify-content-evenly">
                    @foreach($dartboards as $d)
                        <div class="col p-1 mb-2 text-center">
                            <img src="{{ asset($d->image_path) }}" class="rounded" alt="picture of a dartboard" width="60px">
                            <p class="my-1 p-1 lh-1 h-25" style="font-size:.75rem;">{{ $d->name }}</p>
                            <input type="radio" class="btn-check" name="dartboard" id="dartboard{{ $d->id }}" value="{{ $d->uuid }}" autocomplete="off" {{ $d->isAvailable() ?: 'disabled' }} required>
                            <label class="btn btn-primary btn-sm" for="dartboard{{ $d->id }}">{{ $d->isAvailable() ? 'choose' : 'in-game' }}</label>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-6">
                <div class="well">
                    <div class="well-header">
                        Player
                    </div>
                    <div class="accordion accordion-flush" id="accordionPlayer">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dataPlayer{{ $user->id }}">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="btnAddPlayer{{ $user->id }}" name="players[]" value="{{ $user->id }}" checked>
                                    </div>
                                    <div class="d-inline">
                                        <img src="{{ asset('img/user/bl_placeholder.png') }}" class="rounded me-1" alt="user profile image" width="25px">
                                        {{ $user->name }} [Me]
                                    </div>
                                </button>
                            </h2>
                            <div id="dataPlayer{{ $user->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionPlayer">
                                <div class="accordion-body">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr>
                                                <th scope="row"> Fullname </th>
                                                <td> {{ $user->getFullname() }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"> Age </th>
                                                <td> ToDo </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"> Team (dummy)</th>
                                                <td> {{ ['Aftershock', 'Oh Dart', 'Dart Town Boys', 'Team Arrow', 'We’re Trippin’', 'Dart Junkies', 'Galloping Ghosts', 'Dart Daddies', 'Dart Baddies'][rand(0, 8)] }} </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"> Average Score </th>
                                                <td> ToDo </td>
                                            </tr>                              
                                            <tr>
                                                <th scope="row"> Win / Lose </th>
                                                <td> 420 / 69 </td>
                                            </tr>
                                            <tr>
                                                <th scope="row"> Total played games </th>
                                                <td> 489 </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @foreach($players as $p)
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#dataPlayer{{ $p->id }}">
                                        <input type="checkbox" class="btn-check" id="btnAddPlayer{{ $p->id }}">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="btnAddPlayer{{ $p->id }}" name="players[]" value="{{ $p->id }}">
                                        </div>

                                        <div class="d-inline">
                                            <img src="{{ asset('img/user/bl_placeholder.png') }}" class="rounded me-1" alt="user profile image" width="25px">
                                            {{ $p->name }} [{{ $p->getFullname() }}]
                                        </div>
                                    </button>
                                </h2>
                                <div id="dataPlayer{{ $p->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionPlayer">
                                    <div class="accordion-body">
                                        <table class="table table-hover">
                                            <tbody>
                                                <tr>
                                                    <th scope="row"> Fullname </th>
                                                    <td> {{ $p->getFullname() }} </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"> Age </th>
                                                    <td> ToDo </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"> Team (dummy)</th>
                                                    <td> {{ ['Aftershock', 'Oh Dart', 'Dart Town Boys', 'Team Arrow', 'We’re Trippin’', 'Dart Junkies', 'Galloping Ghosts', 'Dart Daddies', 'Dart Baddies'][rand(0, 8)] }} </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"> Average Score </th>
                                                    <td> ToDo </td>
                                                </tr>                              
                                                <tr>
                                                    <th scope="row"> Win / Lose </th>
                                                    <td> 420 / 69 </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row"> Total played games </th>
                                                    <td> 489 </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @csrf
        <button type="submit" class="btn btn-primary" for="gameForm">Submit</button>
    </form>
</div>
@endsection