<x-guest-layout>
       
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li  style="color: red" class="text-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Usercode -->
            <div>
                <x-input-label for="usercode" :value="__('Mã nhân viên')" />
                <x-text-input id="usercode" class="block mt-1 w-full" type="text" name="usercode" :value="old('usercode')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mật khẩu')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Đăng nhập') }}
                </x-primary-button>
            </div>
        </form>
</x-guest-layout>
