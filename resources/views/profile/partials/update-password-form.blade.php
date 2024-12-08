<section>
    <header>
        <h3 class="m-0 p-0">
            {{ __('Thay Đổi Mật Khẩu') }}
        </h3>
    </header>

    <form id="password-change-form" method="post" action="{{ route('password.update') }}" class=" mt-3  pb-3 space-y-6">
        @csrf
        @method('put')

        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">Mật khẩu hiện tại</label>
            <input class="form-control" id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
            <div id="current_password_error" class="text-danger mt-2" style="display:none;"></div>
        </div>

        <div class="mb-3">
            <label for="update_password_password" class="form-label">Mật Khẩu mới</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
            <div id="password_error" class="text-danger mt-2" style="display:none;"></div>
        </div>

        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
            <div id="password_confirmation_error" class="text-danger mt-2" style="display:none;"></div>
        </div>

        <div class="d-flex ">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p class="text-success mb-0 ms-2 mt-2" x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>

    <script>
        document.getElementById('password-change-form').addEventListener('submit', function(event) {
            let valid = true;
            // Reset previous errors
            document.getElementById('current_password_error').style.display = 'none';
            document.getElementById('password_error').style.display = 'none';
            document.getElementById('password_confirmation_error').style.display = 'none';

            // Validate current password
            const currentPassword = document.getElementById('update_password_current_password').value;
            if (currentPassword === '') {
                document.getElementById('current_password_error').innerText = 'Mật khẩu hiện tại không được để trống';
                document.getElementById('current_password_error').style.display = 'block';
                valid = false;
            }

            // Validate new password
            const newPassword = document.getElementById('update_password_password').value;
            if (newPassword === '') {
                document.getElementById('password_error').innerText = 'Mật khẩu mới không được để trống';
                document.getElementById('password_error').style.display = 'block';
                valid = false;
            }

            // Validate password confirmation
            const confirmPassword = document.getElementById('update_password_password_confirmation').value;
            if (confirmPassword !== newPassword) {
                document.getElementById('password_confirmation_error').innerText = 'Mật khẩu xác nhận không khớp';
                document.getElementById('password_confirmation_error').style.display = 'block';
                valid = false;
            }

            if (!valid) {
                event.preventDefault(); // Prevent form submission if invalid
            }
        });
    </script>
</section>
