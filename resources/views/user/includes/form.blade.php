<div class="row justify-content-center">
    <form action="{{ $action === 'create' ? route('user.store') : route('user.update', $user->id) }}" method="POST" id="userform">
        @csrf
        @if($action !== 'create')
            @method('PUT')
        @endif
        <div class="mb-3">
            <label for="name" class="form-check-label">{{ __('Username') }}</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') || $action === 'create' ? old('name') : $user->name }}" required autocomplete="off" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="firstname" class="form-check-label">{{ __('Firstname') }}</label>
            <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') || $action === 'create' ? old('firstname') : $user->firstname }}" autocomplete="off">
            @error('firstname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="lastname" class="form-check-label">{{ __('lastname') }}</label>
            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') || $action === 'create' ? old('lastname') : $user->lastname }}" autocomplete="off">
            @error('lastname')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-check-label">{{ __('Email Address') }}</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') || $action === 'create' ? old('email') : $user->email }}" required autocomplete="off">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-check-label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="new password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="role" class="form-check-label">{{ __('Role') }}</label>
            <select id="role" name="role" form="userform" class="form-select" size="5" aria-label="size 5 select example" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ isset($user) ? ($user->role_id === $role->id) ? 'selected' : '' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
</div>