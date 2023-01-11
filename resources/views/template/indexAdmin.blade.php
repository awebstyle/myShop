<!DOCTYPE html>
<html lang="en">
  @include('template.partialsAdmin._head')
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @include('template.partialsAdmin._navbar')

    @include('template.partialsAdmin._sidebar')

    @yield('content')
  @include('template.partialsAdmin._footer')
  @include('template.partialsAdmin._controlSidebar')
  @include('template.partialsAdmin._scripts')
  </div>
</body>
</html>
