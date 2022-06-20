@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row pb-4 pt-2">
        <h3 class="col-8">
            Checkout Calculator
        </h3>
        <small class="text-muted">
            Description: TODO Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, nesciunt earum. Voluptatibus tempore corrupti odio ut cumque Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, nesciunt earum. porro enim, iste optio molestiae dignissimos soluta sapiente nam similique officia fugiat sit.
        </small>
    </div>

    <div class="row d-flex justify-content-between">
        <div class="col-6 d-flex justify-content-end align-items-center">
            <form action="{{ route('utillity.viewCheckouts') }}" method="GET" id="checkoutForm">
                <div class="row g-3 align-items-center pb-4">
                    <div class="col-auto">
                        <label for="score" class="col-form-label"> Score </label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="score" name="score" class="form-control form-control-lg" value="{{ old('score')?old('score'):$score }}" min="2" max="170" required>
                    </div>
                    <div class="col-auto">
                        <span id="passwordHelpInline" class="form-text">
                            2 - 170
                        </span>
                    </div>
                </div>
                <div class="row pb-4">
                    <div class="col d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn btn-primary">
                            let's go...
                        </button>
                    </div>
                </div>
                @csrf
            </form>
        </div>
        <div class="col-5 d-flex flex-column justify-content-center">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="limitResults" name="limitResults" form="checkoutForm" {{ $limitResults ? 'checked' : null}}>
                <label class="form-check-label" for="limitResults">Limit to 150 results</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="highlightBestOption" name="highlightBestOption" form="checkoutForm" {{ $highlightBestOption ? 'checked' : null}}>
                <label class="form-check-label" for="highlightBestOption">Highlight best option</label>
            </div>
            <div class="form-check form-switch pb-2">
                <input class="form-check-input" type="checkbox" role="switch" id="showWeights" name="showWeights" form="checkoutForm" {{ $showWeights ? 'checked' : null}}>
                <label class="form-check-label"  for="showWeights"><span class="text-muted" style="font-size: .75em;">(debug)</span> Show Weights</label>
            </div>
            <div class="text-center">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="true" id="singleOut" name="singleOut" form="checkoutForm" {{ $singleOut ? 'checked' : null}}>
                    <label class="form-check-label" for="singleOut">Single-Out</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="true" id="doubleOut" name="doubleOut" form="checkoutForm" {{ $doubleOut ? 'checked' : null}}>
                    <label class="form-check-label" for="doubleOut">Double-Out</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="true" id="trippleOut" name="trippleOut" form="checkoutForm" {{ $trippleOut ? 'checked' : null}}>
                    <label class="form-check-label" for="trippleOut">Tripple-Out</label>
                </div>
            </div>
        </div>
    </div>
    
    @if($checkoutNumOfPossibilities)
        <div class="row">
            <p> Calculated {{ $checkoutNumOfPossibilities }} possible checkouts ({{ $execTime }} seconds)</p>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col">
            <table class="table table-striped table-hover" id="checkoutTable">
                <thead>
                    <tr>
                        <th scope="col" style="width:100px;"><i class="fa-solid fa-hashtag"></i></th>
                        <th scope="col"><i class="fa-solid fa-1"></i>.</th>
                        <th scope="col"><i class="fa-solid fa-2"></i>.</th>
                        <th scope="col"><i class="fa-solid fa-3"></i>.</th>
                        @if($showWeights)
                            <th scope="col"><i class="fa-solid fa-weight-hanging"></i></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($checkouts_0)
                        @if($highlightBestOption)
                            @if($checkoutBestOption >= 0 && $checkoutBestOption <= count($checkouts_0)-1)
                                <tr class="table-success">
                                    <th scope="row"> BEST #{{ $checkoutBestOption }}</th>
                                    <td scope="row">{{ $checkouts_0[$checkoutBestOption][0] }}</td>
                                    <td scope="row">{{ $checkouts_0[$checkoutBestOption][1] }}</td>
                                    <td scope="row">{{ $checkouts_0[$checkoutBestOption][2] }}</td>
                                    @if($showWeights)
                                        <td scope="row">{{ $checkouts_0[$checkoutBestOption][3] }}</td>
                                    @endif
                                </tr>
                            @else 
                                <tr class="table-success">
                                    <th scope="row"> BEST #{{ $checkoutBestOption }}</th>
                                    <td scope="row">{{ $checkouts_1[$checkoutBestOption][0] }}</td>
                                    <td scope="row">{{ $checkouts_1[$checkoutBestOption][1] }}</td>
                                    <td scope="row">{{ $checkouts_1[$checkoutBestOption][2] }}</td>
                                    @if($showWeights)
                                        <td scope="row">{{ $checkouts_1[$checkoutBestOption][3] }}</td>
                                    @endif
                                </tr>
                            @endif
                        @endif
                        @foreach ($checkouts_0 as $key => $checkout )
                            <tr class="{{ $checkoutBestOption == $key && $highlightBestOption ? 'table-dark' : null }}">
                                <th scope="row">{{ $key }}</th>
                                <td scope="row">{{ $checkout[0] }}</td>
                                <td scope="row">{{ $checkout[1] }}</td>
                                <td scope="row">{{ $checkout[2] }}</td>
                                @if($showWeights)
                                    <td scope="row">{{ $checkout[3] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center table-danger">
                            <th scope="row" colspan="4" >not enough data.</th>
                        </tr>
                        @foreach([".....", "....", "...", "..", "."] as $c)
                            {{--<tr class="text-center opacity-{{75-$loop->index*25}}">--}}
                            <tr class="text-center" style="opacity:{{.75-$loop->index*.2}};">
                                <th scope="row" colspan="4">{{ $c }}</th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="col">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col"><i class="fa-solid fa-hashtag"></i></th>
                        <th scope="col"><i class="fa-solid fa-1"></i>.</th>
                        <th scope="col"><i class="fa-solid fa-2"></i>.</th>
                        <th scope="col"><i class="fa-solid fa-3"></i>.</th>
                        @if($showWeights)
                            <th scope="col"><i class="fa-solid fa-weight-hanging"></i></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if($checkouts_1)
                        @foreach ($checkouts_1 as $key => $checkout )
                            <tr class="{{ $checkoutBestOption == $key && $highlightBestOption ? 'table-dark' : null }}">
                                <th scope="row">{{ $key }}</th>
                                <td scope="row">{{ $checkout[0] }}</td>
                                <td scope="row">{{ $checkout[1] }}</td>
                                <td scope="row">{{ $checkout[2] }}</td>
                                @if($showWeights)
                                    <td scope="row">{{ $checkout[3] }}</td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr class="text-center table-danger">
                            <th scope="row" colspan="4" >not enough data.</th>
                        </tr>
                        @foreach([".....", "....", "...", "..", "."] as $c)
                            {{--<tr class="text-center opacity-{{75-$loop->index*25}}">--}}
                            <tr class="text-center" style="opacity:{{.75-$loop->index*.2}};">
                                <th scope="row" colspan="4">{{ $c }}</th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection