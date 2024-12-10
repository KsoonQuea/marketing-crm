<x-user.guest-layout>
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    @endpush
    <section class="register bg__img" data-background="{{ asset('landing-assets/images/auth-bg.png') }}">
        <div class="container">
            <div class="register__area">
                <h3 class="content__space--small text-center">DAFTAR</h3>
                <form method="POST" action="{{ route('user.register') }}">
                    @csrf
                    <div class="input__grp content__space">
                        <div class="row d-flex align-items-start">
                            <div class="col-md-12">
                                <div class="input__area text-start">
                                    <label for="username" class="content__space--small">Username</label>
                                    <input type="text" name="username" id="username"
                                           class="@error('username') tw-border-red-500 tw-mb-2 @enderror"
                                           placeholder="Username 8-16 karakter standar (A~Z,a~z,0-9) dan tanpa spasi"
                                           required="required"
                                            value="{{ old('username') }}"/>
                                    @error('username')
                                        <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input__grp content__space">
                        <div class="row d-flex align-items-start">
                            <div class="col-md-6">
                                <div class="input__area text-start">
                                    <label for="regiPass" class="content__space--small">Password</label>
                                    <div class="show__hide__password">
                                        <input type="password" name="password" id="regiPass"
                                               class="@error('password') tw-border-red-500 tw-mb-2 @enderror"
                                               placeholder="Password (8 karakter atau lebih)" required/>
                                        <i class="fas fa-eye-slash toggle__password"></i>
                                        @error('password')
                                        <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input__area text-start">
                                    <label for="retypePass" class="content__space--small">Konfirmasi Password</label>
                                    <div class="show__hide__password">
                                        <input type="password" name="password_confirmation" id="retypePass"
                                               placeholder="Password sekali lagi" required="required"/>
                                        <i class="fas fa-eye-slash retype__toggle__password"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input__grp cta__space">
                        <div class="row d-flex align-items-start">
                            <div class="col-md-6">
                                <div class="input__area text-start">
                                    <label for="mail" class="content__space--small">E-mail</label>
                                    <input type="email" name="email" id="mail" placeholder="Masukkan Email"
                                           class="@error('email') tw-border-red-500 tw-mb-2 @enderror"
                                           required
                                           value="{{ old('email') }}"/>
                                    @error('email')
                                    <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input__area text-start">
                                    <label for="retypePhone" class="content__space--small">Telpon</label>
                                    <input type="number" name="contact_no" id="retypePhone"
                                           class="@error('contact_no') tw-border-red-500 tw-mb-2 @enderror"
                                           placeholder="Masukkan Telpon" required
                                           value="{{ old('contact_no') }}"/>
                                    @error('contact_no')
                                    <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input__grp cta__space">
                        <div class="row d-flex align-items-start">
                            <div class="col-md-6 settings__tab__content">
                                <div class="input__area text-start alt">
                                    <label for="bank" class="content__space--extra--small @error('bank') tw-text-red-500 @enderror">Bank</label>
                                    <select id="bank" name="bank" class="select2">
                                        <option value="">Pilih Bank</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('bank')
                                    <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input__area text-start">
                                    <label for="bankNumber" class="content__space--small">No. Rekening</label>
                                    <input type="number" name="bank_account" id="bankNumber"
                                           class="@error('bank_account') tw-border-red-500 tw-mb-2 @enderror"
                                           placeholder="Masukkan Nomor Rekening" required
                                           value="{{ old('bank_account') }}"/>
                                    @error('bank_account')
                                    <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input__grp cta__space">
                        <div class="row d-flex align-items-start">
                            <div class="col-md-6">
                                <div class="input__area text-start">
                                    <label for="bankName" class="content__space--small">Nama sesuai Rekening</label>
                                    <input type="text" name="bank_owner" id="bankName"
                                           class="@error('bank_owner') tw-border-red-500 tw-mb-2 @enderror"
                                           placeholder="Nama sesuai Rekening" required
                                           value="{{ old('bank_owner') }}"/>
                                    @error('bank_owner')
                                    <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input__area text-start">
                                    <label for="referral" class="content__space--small">Referral</label>
                                    <input type="text" name="referral" id="referral"
                                           class="@error('referral') tw-border-red-500 tw-mb-2 @enderror"
                                           placeholder="Referral bila ada"
                                           value="{{ old('referral') }}"/>
                                    @error('referral')
                                    <span class="tw-text-red-500 tw-pl-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input__area__alt cta__space">
                        <div class="input__area__alt__inner">
                            <input type="checkbox" name="agreement" id="agreement" checked="checked" value="{{ old('agreement', 1) }}"/>
                            <label for="agreement" class="@error('referral') tw-text-red-500 tw-mb-2 @enderror">Dengan ini saya menyatakan bahwa saya telah membaca dan menyetujui
                                Kebijakan Privasi pada Situs ini.</label>
                        </div>
                    </div>
                    <button type="submit" class="button content__space">DAFTAR</button>
                    <p class="text-center">Sudah memiliki akun ? <a href="{{ route('user.login') }}">MASUK</a></p>
                </form>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(".select2").select2();
            @if(old('bank'))
                $('#bank').val('{{ old('bank') }}').trigger('change');
            @endif
        </script>
    @endpush
</x-user.guest-layout>
