<x-user.guest-layout>
    <section class="register bg__img" data-background="{{ asset('landing-assets/images/auth-bg.png') }}">
        <div class="container">
            <div class="register__area login__area">
                <h3 class="content__space--small text-center">Selamat Datang kembali!</h3>
                <p class="mb-55 text-center">Masukkan detail Anda di bawah ini.</p>
                @error('username')
                <div class="alert alert-danger mb-55" role="alert">
                    {{ $message  }}
                </div>
                @enderror
                <form action="{{ route('user.login') }}" method="POST">
                    @csrf
                    <div class="input__area text-start content__space">
                        <label for="loginUsername" class="content__space--small">Username</label>
                        <input type="text" name="username" id="loginUsername" placeholder="Username"
                               required="required" autocomplete="username"/>
                    </div>
                    <div class="input__area text-start content__space--small">
                        <label for="loginPass" class="content__space--small">Password</label>
                        <div class="show__hide__password">
                            <input type="password" name="password" id="loginPass" placeholder="Password"
                                   required="required"/>
                            <i class="fas fa-eye-slash login__toggle__password"></i>
                        </div>
                    </div>
                    <div class="input__area__alt cta__space">
                        <div class="input__area__alt__inner">
                            <input type="checkbox" name="remember" id="rememberPass" checked="checked"/>
                            <label for="rememberPass">Remember Me</label>
                        </div>
                        <a href="javascript:void(0)">Lupa kata sandi Anda</a>
                    </div>
                    <button type="submit" class="button content__space">MASUK</button>
                    <p class="text-center">Tidak punya akun? <a href="{{ route('user.register') }}">DAFTAR</a></p>
                </form>
            </div>
        </div>
    </section>
</x-user.guest-layout>
