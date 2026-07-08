<x-app-layout>
    <x-slot name="header">
        <h2 class="pos-page-title">{{ __('Profile') }}</h2>
        <p class="pos-page-subtitle">MANAGE USER ACCOUNT SETTINGS</p>
    </x-slot>

    <div class="fade-up" style="max-w: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
        <div class="glass-card">
            <div class="glass-card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="glass-card">
            <div class="glass-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="glass-card">
            <div class="glass-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
