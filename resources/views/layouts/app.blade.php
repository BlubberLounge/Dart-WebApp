<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('includes.head')

<body>
    <div id="app">

        @include('includes.nav')

        @include('includes.alerts')

        <main class="py-4">
            @yield('content')
        </main>

    </div>
</body>
</html>
