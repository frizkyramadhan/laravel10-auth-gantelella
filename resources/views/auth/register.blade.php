<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>{{ $title }} - Laravel 10 Auth Gentelella</title>

  <!-- Bootstrap -->
  <link href="{{ asset('assets/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- NProgress -->
  <link href="{{ asset('assets/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
  <!-- Custom Theme Style -->
  <link href="{{ asset('assets/build/css/custom.min.css') }}" rel="stylesheet">
</head>

<body class="login">
  <div>
    <div class="login_wrapper">
      <div id="register">
        <section class="login_content">
          <form data-parsley-validate action="{{ route('register') }}" method="POST" autocomplete="off">
            @csrf
            <h1>Create Account</h1>
            <div>
              <input type="text" name="name" required="required" class="form-control" placeholder="Full Name" autofocus>
            </div>
            <div>
              <input type="text" id="email_address" name="email" class="form-control" required placeholder="@arka.co.id" pattern="^[a-z0-9._%+\-]+@arka\.co\.id$" data-parsley-pattern="^[a-z0-9._%+\-]+@arka\.co\.id$" data-parsley-type="email" data-parsley-trigger="focusout" data-parsley-checknewemail placeholder="Email Address" />
            </div>
            <div>
              <input class="form-control" type="password" name="password" required placeholder="Password">
            </div>
            <div>
              <button type="submit" class="btn btn-default submit">Submit</button>
            </div>

            <div class="clearfix"></div>

            <div class="separator">
              <p class="change_link">Already a member?
                <a href="{{ url('login') }}" class="to_register"> Log in </a>
              </p>

              <div class="clearfix"></div>
              <br />

              <div>
                <h1><i class="fa fa-code"></i> Laravel 10 Auth</h1>
                <p>©2023 All Rights Reserved.</p>
              </div>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('assets/vendors/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap -->
  <script src="{{ asset('assets/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- FastClick -->
  <script src="{{ asset('assets/vendors/fastclick/lib/fastclick.js') }}"></script>
  <!-- NProgress -->
  <script src="{{ asset('assets/vendors/nprogress/nprogress.js') }}"></script>
  <!-- Parsley -->
  <script src="{{ asset('assets/vendors/parsleyjs/dist/parsley.min.js') }}"></script>
  {{-- script new email unique validation --}}
  <script>
    $(document).ready(function() {

      $('#email_address').parsley();

      window.Parsley.addValidator('checknewemail', {
        validateString: function(value) {
          return $.ajax({
            url: "{{ route('users.checknewemail') }}"
            , method: "POST"
            , data: {
              email: value
              , _token: '{!! csrf_token() !!}'
            }
            , dataType: "json"
            , success: function(data) {
              return data.success; // Kembalikan true atau false dari respons JSON
            }
          });
          console.log(value);
        }
        , messages: {
          en: 'This email is already registered.' // Pesan jika validasi gagal
        }
      });

    });

  </script>
</body>
</html>
