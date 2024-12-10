<div class="sidebar">
    <a href="javascript:void(0)" class="close__sidebar">
        <i class="fas fa-times"></i>
    </a>
    <div class="sidenav__wrapper">
        <ul>
            <li>
                <a href="#" class="tw-flex tw-flex-col hover:tw-bg-[#3d3d98] tw-cursor-auto">
                    <p class="tw-font-bold">Balance</p>
                    <p>Rp. {{ number_format(balance()) }}</p>
                </a>
            </li>
            <li>
                <a href="{{ route('user.index') }}" class="{{ routeActive('user.index') }}">
                    <img src="{{ asset('landing-assets/icons/dashboard.png') }}" class="tw-w-6" alt="dashboard"/> Dasbor
                </a>
            </li>
            <li>
                <a href="{{ route('user.deposit') }}" class="{{ routeActive('user.deposit') }}">
                    <img src="{{ asset('landing-assets/icons/deposit.png') }}" class="tw-w-6" alt="Deposit"/> Deposit
                </a>
            </li>
            <li>
                <a href="{{ route('user.withdraw') }}" class="{{ routeActive('user.withdraw') }}">
                    <img src="{{ asset('landing-assets/icons/withdraw.png') }}" class="tw-w-6" alt="Withdrawal"/>
                    Withdraw
                </a>
            </li>
            <li>
                <a href="{{ route('user.togel') }}">
                    <img src="{{ asset('landing-assets/icons/togel.png') }}" class="tw-w-6" alt="Lottery"/> Togel
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{ asset('landing-assets/icons/bank.png') }}" class="tw-w-7" alt="Investment"/> Rekening
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{ asset('landing-assets/icons/transaction.png') }}" class="tw-w-4" alt="History"/>
                    Transaksi
                </a>
            </li>
        </ul>
        <hr/>
        <ul class="logout">
            <li>
                <a href="#"
                   onclick="event.preventDefault(); $('.logoutform').submit();">
                    <img src="{{ asset('landing-assets/images/icons/logout.png') }}" alt="Logout"/> Keluar
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav__wrapper sidenav__footer">
        <h6>Last Login</h6>
        <hr/>
        <div class="sidenav__time">
            <p class="tertiary">
                <img src="{{ asset('landing-assets/images/icons/login.png') }}" alt="Login"/>
                {{ auth('user')->user()?->last_login_at?->format('d.m.Y') ?? 'N/A' }}</p>
            <p class="tertiary">{{ auth('user')->user()?->last_login_at?->format('H:i:s') ?? '' }}</p>
        </div>
    </div>
</div>
