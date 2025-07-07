<x-app-layout>
    <x-slot name="header">
        <div class="py-4 bg-light border-bottom">
            <div class="container">
                <h2 class="fw-bold h4 m-0 text-dark">
                    {{ __('Profile') }}
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="row gy-4">
                {{-- Update Profile Information --}}
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                {{-- Update Password --}}
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                {{-- Delete User --}}
                <div class="col-12 col-md-8 offset-md-2">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
