@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row pb-4 pt-2">
        <h3 class="col-8">
            Dartboard: Wedge/Field values
        </h3>
        <small class="text-muted">
            Description: TODO Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, nesciunt earum. Voluptatibus tempore corrupti odio ut cumque Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, nesciunt earum. porro enim, iste optio molestiae dignissimos soluta sapiente nam similique officia fugiat sit.
        </small>
    </div>
    
    <div class="row">
        <div class="col dartboard d-flex justify-content-center align-items-center">
            <ul class="dartboard_ring">
                @for($i=0; $i <= sizeOf($dartboard[0])-1; $i++)
                    @foreach($dartboard as $j => $row)
                        <li class="text-center" style="font-weight: bold;--item-count:{{ $j }};--radius: {{ ($i+1.8)*3.4 }}rem;color:#f8fafc;background-color:{{ $j % 2 == 0 & (sizeOf($dartboard[0])-1-$i) % 2 == 0  || (sizeOf($dartboard[0])-1-$i) == 4 ? '#E3292E' : ((sizeOf($dartboard[0])-1-$i) % 2 == 0 & (sizeOf($dartboard[0])-1-$i) <= 3 || (sizeOf($dartboard[0])-1-$i) == 5 ? '#309F6A' : '#F9DFBC') }};">
                            {{ $row[sizeOf($dartboard[0])-1-$i], 1 }}
                        </li>
                    @endforeach
                @endfor
            </ul>
        </div>
    </div>

    <div class="row pb-4 pt-2">
        <h3 class="col-8">
            Heatmap: Wedge/Field values
        </h3>
        <small class="text-muted">
            Description: TODO Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, nesciunt earum. Voluptatibus tempore corrupti odio ut cumque Lorem ipsum dolor sit amet consectetur adipisicing elit. Eaque, nesciunt earum. porro enim, iste optio molestiae dignissimos soluta sapiente nam similique officia fugiat sit.
        </small>
    </div>

    <div class="row">
        <div class="col dartboard d-flex justify-content-center align-items-center">
            <ul class="dartboard_ring">
                @for($i=0; $i <= sizeOf($dartboard[0])-1; $i++)
                    @foreach($dartboard as $j => $row)
                        <li class="text-center" style="font-weight: bold;--item-count:{{ $j }};--radius: {{ ($i+1.8)*3.4 }}rem;color:#000;opacity:{{ $dartboardHeat[$j][sizeOf($dartboard[0])-1-$i] }};background-color:{{ $j % 2 == 0 & (sizeOf($dartboard[0])-1-$i) % 2 == 0  || (sizeOf($dartboard[0])-1-$i) == 4 ? '#E3292E' : ((sizeOf($dartboard[0])-1-$i) % 2 == 0 & (sizeOf($dartboard[0])-1-$i) <= 3 || (sizeOf($dartboard[0])-1-$i) == 5 ? '#309F6A' : '#F9DFBC') }};">
                            {{ round($row[sizeOf($dartboard[0])-1-$i], 1) }}
                        </li>
                    @endforeach
                @endfor
            </ul>
        </div>
    </div>
    
    <div class="row pb-4 pt-2">
        <h3 class="col-8">
            Heatmap: Average of nearest neighbour Wedge/Field values
        </h3>
        <small class="text-muted">
            Description: This Dartboard chart shows the average value of nearby wedges/fields. In other words... fields down below with a high number have a field with high values next to them. Therefore they're a good choice in case your throws aren't that accurate and or you fear to miss the desired target field.
        </small>
    </div>

    <div class="row">
        <div class="col dartboard d-flex justify-content-center align-items-center">
            <ul class="dartboard_ring">
                @for($i=2; $i <= sizeOf($dartboardAverages[0])-1; $i++)
                    @foreach($dartboardAverages as $j => $row)
                        <li class="text-center" style="--item-count:{{ $j }};--radius: {{ ($i+1)*3.4 }}rem;color:rgba(255,0,0,{{ $dartboardAveragesHeat[$j][sizeOf($dartboard[0])-1-$i] }});">
                            {{ round($row[sizeOf($dartboard[0])-1-$i], 1) }}
                        </li>
                    @endforeach
                @endfor
                @foreach($dartboard as $j => $row)
                    <li class="text-center" style="--item-count:{{ $j }};--radius: 7rem;color:#32a63b;font-weight: bold;">
                            {{ $row[1] }}
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection