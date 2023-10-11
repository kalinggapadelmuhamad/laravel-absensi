<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }}</title>

        {{-- logo --}}
        <link rel="shorcut icon" href="{{ asset('assets/img/absensi.png') }}">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
        {{-- select picker --}}
        <link rel="stylesheet"
            href="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css') }}">

        {{-- timepicker --}}
        <link rel="stylesheet" href="{{ asset('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css') }}">

    </head>

    <body class="hold-transition login-page" style="background-image: url({{ asset('assets/img/absenbg.jpg') }});">

        <div class="login-box">
            @yield('auth')
        </div>
        <!-- /.login-box -->

        <!-- jQuery -->
        <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
        {{-- selectpicker --}}
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js') }}">
        </script>
        <script src="{{ asset('https://cdn.jsdelivr.net/npm/flatpickr') }}"></script>

        <script>
            config = {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
            }

            flatpickr("input[type=datetime-local]", config)
            flatpickr("input[type=datetime]", {})
        </script>
        <script>
            $(function() {
                $('form').on('submit', function() {
                    $(':input[type="submit"]').prop('disabled', true);
                })
            })
        </script>
    </body>

</html>
