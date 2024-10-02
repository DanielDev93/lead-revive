<x-guest-layout>
    <div class="padding-top-40">
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="card-body">
            <div x-data="{ recovery: false }">
                <div class="mb-3" x-show="! recovery">
                    {{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
                </div>

                <div class="mb-3" x-show="recovery">
                    {{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}
                </div>

                <x-jet-validation-errors class="mb-3" />

                <form method="POST" action="/two-factor-challenge">
                    @csrf

                    <div class="mt-4" x-show="! recovery">
                        <x-jet-label value="{{ __('Code') }}" />
                        <x-jet-input class="{{ $errors->has('code') ? 'is-invalid' : '' }}" type="text"
                                     name="code" autofocus x-ref="code" autocomplete="one-time-code" />
                        <x-jet-input-error for="code"></x-jet-input-error>
                    </div>

                    <div class="mt-4" x-show="recovery">
                        <x-jet-label value="{{ __('Recovery Code') }}" />
                        <x-jet-input class="{{ $errors->has('recovery_code') ? 'is-invalid' : '' }}" type="text"
                                     name="recovery_code" x-ref="recovery_code" autocomplete="one-time-code" />
                        <x-jet-input-error for="recovery_code"></x-jet-input-error>
                    </div>

                    <div class="mt-3 flex justify-content">
                        <button type="button" class="btn btn-outline-secondary p-2"
                                x-show="! recovery"
                                x-on:click="
                                            recovery = true;
                                            $nextTick(() => { $refs.recovery_code.focus() })
                                        ">
                            {{ __('Use a recovery code') }}
                        </button>

                        <button type="button" class="btn btn-outline-secondary p-2"
                                x-show="recovery"
                                x-on:click="
                                            recovery = false;
                                            $nextTick(() => { $refs.code.focus() })
                                        ">
                            {{ __('Use an authentication code') }}
                        </button>

                        <x-jet-button class="mt-3 d-flex flex-row-reverse">
                            {{ __('Login') }}
                        </x-jet-button>
                    </div>
                </form>
            </div>
        </div>
    </x-jet-authentication-card>
    </div>
</x-guest-layout>