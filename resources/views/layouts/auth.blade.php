<!DOCTYPE html>
<html lang="en">

<head>
    @include('includes.meta')

    <title>@yield('title') | MeetDoctor</title>

    @stack('before-style')
    @include('includes.style')
    @stack('after-style')

</head>

<body>

    @yield('content')

    @stack('before-script')
    @include('includes.script')
    @stack('after-script')

</body>

</html>
