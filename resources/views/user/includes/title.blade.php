@if(Request::path() !== 'user')
    <div class="row">
        <a href="{{ url()->previous() }}">
            <i class="fa-solid fa-caret-left"></i>
            {{ __('Back') }}
        </a> 
    </div>
@endif

<div class="row pb-4 pt-2">
    <h3 class="col-8">
        User Management
        <small class="text-muted">{{ substr(Route::currentRouteAction(), strpos(Route::currentRouteAction(), "@") + 1) }}</small>
    </h3>

    @if(Request::path() === 'user')
        <div class="col-4 d-flex justify-content-end">
            <a class="btn btn-primary" href="{{ route('user.create') }}" role="button">
                <i class="fa-solid fa-circle-plus fa-lg pe-2"></i>
                Add User
            </a>
        </div>
    @endif
</div>
