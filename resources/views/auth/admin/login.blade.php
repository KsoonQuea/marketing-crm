<x-admin.guest-layout>
    <section>
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="login-card">
                        <form class="theme-form login-form" action="{{ route('admin.login') }}" method="POST">
                            @csrf
                            <h4>Login</h4>
                            <h6>Welcome to Admin Portal.</h6>
                            @if ($errors->any())
                                <div class="tw-mb-4">
                                    <ul class="tw-mt-3 tw-list-disc tw-list-inside tw-text-sm tw-text-red-600 tw-list-none">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group">
                                <label>{{ __('Email') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="icon-email"></i></span>
                                    <input class="form-control" name="email" type="email" value="{{ old('email') }}"
                                           required
                                           autofocus/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Password') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="icon-lock"></i></span>
                                    <input class="form-control" type="password" name="password" required
                                           autocomplete="current-password"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input id="remember_me" type="checkbox" name="remember"/>
                                    <label for="remember_me">{{ __('Remember me') }}</label>
                                </div>
                                {{--                                @if (Route::has('admin.password.request'))--}}
                                {{--                                    <a class="link"--}}
                                {{--                                       href="{{ route('admin.password.request') }}">{{ __('Forgot your password?') }}</a>--}}
                                {{--                                @endif--}}
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">{{ __('Log in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-admin.guest-layout>
