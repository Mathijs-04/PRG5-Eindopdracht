{{--Login Check--}}
@if(auth()->check())
    <h1>This user is logged in</h1>
@else
    <h1>This user is not logged in</h1>
@endif

