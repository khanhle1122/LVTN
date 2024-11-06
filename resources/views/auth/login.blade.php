
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>QLDAXD</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('frontend/style.css') }}">
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Scripts -->
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        

    </head>
    <body class="">
        <div class="container">
          @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

          <div>
            <div class="text-center mt-5">
              <img class="logo-login" src="{{ asset('image/TITC.png') }}" alt="">
            </div>
            <div>
              <form action="{{ route('login') }}" method="POST" class="form-login border border-1 rounded">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="usercode" class="form-label">Mã nhân viên:</label>
                    <input type="text" class="form-control @error('usercode') is-invalid @enderror" id="usercode" placeholder="Nhập mã nhân viên" name="usercode" value="{{ old('usercode') }}" required>
                    @error('usercode')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật Khẩu:</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="Nhập mật khẩu" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-check mb-3">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember"> Ghi Nhớ
                    </label>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
                </div>
              </form>
                  
            </div>    
          </div>
          
           

        </div>
    </body>
</html>  
