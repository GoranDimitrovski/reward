<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @section('head')
        @include('partials.head')
        @show
    </head>
    <body>
        @include('partials.header')

        <div class="container">
            @yield('content')
        </div>

        @section('footer')
        @include('partials.footer')
        @show
    </body>
</html>