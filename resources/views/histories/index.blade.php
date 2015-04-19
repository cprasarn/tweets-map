@extends('welcome')

@section('history')
        <div class="row">
            <a href="#" onclick="showMap();">Go Back</a>
        </div>
    @if ( !$histories->count() )
        You have no histories
    @else
        <div>
            <ul>
            @foreach( $histories as $history )
                <li><div class="row">
                    <a href="#" onclick="showMap('<?php echo $history->city?>');"><?php echo $history->city ?></a>
                </div></li>
            @endforeach
            </ul>
        </div>
    @endif
@endsection
