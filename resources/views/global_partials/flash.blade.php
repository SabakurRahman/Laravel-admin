@if(session('message'))
    <div class="alert alert-{{session('class')}}">
        {!! session('message') !!}
    </div>
@endif
