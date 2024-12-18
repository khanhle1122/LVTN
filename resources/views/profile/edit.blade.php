<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Thông tin cá nhân') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="  mx-auto sm:px-6 lg:px-8 space-y-6 row">


            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg row">
                <div class=" col-7">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="col-1"></div>
                <div class="col-4">
                    @include('profile.partials.info')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg ">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
