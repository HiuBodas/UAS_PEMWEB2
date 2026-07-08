<section>
    <header class="mb-6">
        <h2 class="section-title">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-muted">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password" class="pos-label">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="pos-input" autocomplete="current-password" />
            @error('current_password', 'updatePassword')
                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password" class="pos-label">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="pos-input" autocomplete="new-password" />
            @error('password', 'updatePassword')
                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation" class="pos-label">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="pos-input" autocomplete="new-password" />
            @error('password_confirmation', 'updatePassword')
                <div class="pos-error"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="14" height="14" style="display:inline;vertical-align:middle;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg> {{ $message }}</div>
            @enderror
        </div>

        <div class="form-actions" style="border-top: none; margin-top: 1rem; padding-top: 0;">
            <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-muted"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
