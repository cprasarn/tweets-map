@extends('histories')

@section('history')
    @if ( !$histories->count() )
        You have no histories
    @else
        <div>
            @foreach( $histories as $history )
                <div style="border:1px solid #ccc; padding:5px; width:240px;">
                    <?php echo $history->city ?>
                </div>
            @endforeach
        </div>
    @endif
@endsection
