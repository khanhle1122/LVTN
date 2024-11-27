
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
            
          <div>
            <div class="text-center mt-5">
              <img class="logo-login" style="width:200px" src="{{ asset('image/logo.svg') }}" alt="">
            </div>
            <div class="mt-5">
              <form id="signupForm" action="{{ route('login') }}" method="POST" class="form-login border border-1 rounded">
                @csrf
                <div class="mb-3 mt-3">
                    <label for="usercode" class="form-label">Mã nhân viên:</label>
                    <input type="text" class="form-control " id="usercode" placeholder="Nhập mã nhân viên" name="usercode" value="{{ old('usercode') }}" >
                    
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Mật Khẩu:</label>
                    <input type="password" class="form-control " id="password" placeholder="Nhập mật khẩu" name="password" >
                    
                </div>
                
                <div class="d-grid mb-4">
                    <button type="submit" class="btn btn-primary btn-block">Đăng Nhập</button>
                </div>
              </form>
                  
            </div>    
          </div>
          
           

        </div>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configure toastr options
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };
        
            // Get the form element
            const form = document.getElementById('signupForm');
            const usercode = document.getElementById('usercode');
            const password = document.getElementById('password');
        
            // Add submit event listener to the form
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Reset any existing error styles
                resetErrors();
                
                let isValid = true;
                let errors = [];
        
                // Validate usercode
                if (!usercode.value.trim()) {
                    isValid = false;
                    errors.push('Vui lòng nhập mã nhân viên');
                    addErrorStyle(usercode);
                } else if (usercode.value.trim().length < 3) {
                    isValid = false;
                    errors.push('Mã nhân viên phải có ít nhất 3 ký tự');
                    addErrorStyle(usercode);
                }
        
                // Validate password
                if (!password.value.trim()) {
                    isValid = false;
                    errors.push('Vui lòng nhập mật khẩu');
                    addErrorStyle(password);
                } else if (password.value.trim().length < 1) {
                    isValid = false;
                    errors.push('Mật khẩu phải có ít nhất 6 ký tự');
                    addErrorStyle(password);
                }
        
                // If there are errors, show them using toastr
                if (!isValid) {
                    errors.forEach(error => {
                        toastr.error(error);
                    });
                    return;
                }
        
                // If validation passes, submit the form
                form.submit();
            });
        
            // Function to add error style to input
            function addErrorStyle(element) {
                element.classList.add('is-invalid');
                // Add error message below the input
                const errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                errorDiv.textContent = element.name === 'usercode' ? 
                    'Vui lòng nhập mã nhân viên hợp lệ' : 
                    'Vui lòng nhập mật khẩu hợp lệ';
                element.parentNode.appendChild(errorDiv);
            }
        
            // Function to reset error styles
            function resetErrors() {
                const inputs = form.querySelectorAll('input');
                inputs.forEach(input => {
                    input.classList.remove('is-invalid');
                    const errorDiv = input.parentNode.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                });
            }
        
            // Add input event listeners to remove error styling when user starts typing
            [usercode, password].forEach(input => {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                    const errorDiv = this.parentNode.querySelector('.invalid-feedback');
                    if (errorDiv) {
                        errorDiv.remove();
                    }
                });
            });
        
            // Handle backend validation errors if they exist
            
        });
        </script>
        
        <style>
        .is-invalid {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem) !important;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e") !important;
            background-repeat: no-repeat !important;
            background-position: right calc(0.375em + 0.1875rem) center !important;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
        }
        
        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        </style>
</html>  
