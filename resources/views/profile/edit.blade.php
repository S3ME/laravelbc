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
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 d-flex align-items-stretch">
                {{-- Update Profile Information --}}
                <div>
                    <div class="card shadow-sm h-100">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Update Password --}}
                <div>
                    <div class="card shadow-sm h-100">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Delete User --}}
                <div>
                    <div class="card shadow-sm h-100">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
