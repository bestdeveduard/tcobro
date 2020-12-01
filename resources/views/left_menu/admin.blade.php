<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="profile">
            <div class="profile-wrapper">
                <img src="{{ asset('assets/new_theme/images/usuario.png') }}" alt="profile">
                <div class="profile-details">
                    <p class="name">Welcome</p>
                    <p class="name">{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</p>
                </div>
            </div>
        </li>
        @if(Sentinel::inRole('2'))
        <li class="nav-item @if(Request::is('dashboard')) active @endif">
            <a class="nav-link" href="{{ url('dashboard') }}">
                <i class="fas fa-tachometer-alt menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item @if(Request::is('baseuser/*')) active @endif">
            <a class="nav-link" href="{{ url('baseuser/data') }}">
                <i class="fas fa-cash-register menu-icon"></i>
                <span class="menu-title">Base</span>
            </a>
        </li>

            @if(Sentinel::hasAccess('borrowers'))
            <li class="nav-item @if(Request::is('borrower/*')) active @endif">
                <a class="nav-link" href="{{ url('borrower/data') }}">
                    <i class="fas fa-user-friends menu-icon"></i>
                    <span class="menu-title">Borrower</span>
                </a>
            </li>
            @endif

            @if(Sentinel::hasAccess('loans'))
            <li class="nav-item @if(Request::is('loan/*')) active @endif">
                <a class="nav-link" href="{{ url('loan/data') }}">
                    <i class="fab fa-leanpub menu-icon"></i>
                    <span class="menu-title">Loan</span>
                </a>
            </li>
            <li class="nav-item @if(Request::is('loan/loan_product/*')) active @endif">
                <a class="nav-link" href="{{ url('loan/loan_product/data') }}">
                    <i class="fab fa-leanpub menu-icon"></i>
                    <span class="menu-title">Loan Product</span>
                </a>
            </li>
            <li class="nav-item @if(Request::is('loan/loan_repayment_method/*')) active @endif">
                <a class="nav-link" href="{{ url('loan/loan_repayment_method/data') }}">
                    <i class="fab fa-leanpub menu-icon"></i>
                    <span class="menu-title">Loan Payment Method</span>
                </a>
            </li>
            @endif

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-money-bill-wave-alt menu-icon"></i>
                <span class="menu-title">Payments</span>
            </a>
        </li>
        <li class="nav-item @if(Request::is('expense/*')) active @endif">
            <a class="nav-link" href="{{ url('expense/data') }}">
                <i class="fas fa-receipt menu-icon"></i>
                <span class="menu-title">Expenses</span>
            </a>
        </li> 
        <li class="nav-item @if(Request::is('other_income/*')) active @endif">
            <a class="nav-link" href="{{ url('other_income/data') }}">
                <i class="fas fa-file-invoice-dollar menu-icon"></i>
                <span class="menu-title">Income</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-calculator menu-icon"></i>
                <span class="menu-title">Calculator</span>
            </a>
        </li>
        @endif        
        
        <li class="nav-item @if(Request::is('accounting/*')) active @endif @if(Request::is('capital/*')) active @endif">
            <a class="nav-link" data-toggle="collapse" href="#contabilid" aria-expanded="false" aria-controls="contabilid">
                <i class="fas fa-wallet menu-icon"></i>
                <span class="menu-title">Accounting</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="contabilid">
                <ul class="nav flex-column sub-menu">
                    @if(Sentinel::inRole('1'))
                    <li class="nav-item"><a class="nav-link" href="{{ url('chart_of_account/data') }}">Account list</a></li>
                    @endif
                    @if(Sentinel::inRole('2'))
                    <li class="nav-item"><a class="nav-link" href="{{ url('accounting/journal') }}">General diary</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('accounting/ledger') }}">Trial Balance</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('accounting/manual_entry/create') }}">Manual entry</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('capital/data') }}">Capital</a></li>
                    @endif
                </ul>
            </div>
        </li> 

        @if(Sentinel::inRole('2') && Sentinel::hasAccess('reports'))        
        <li class="nav-item @if(Request::is('report/*')) active @endif">
            <a class="nav-link" data-toggle="collapse" href="#reportes" aria-expanded="false" aria-controls="reportes">
                <i class="fas fa-book menu-icon"></i>
                <span class="menu-title">Reports</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="reportes">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/borrower_report') }}">Borrower report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/loan_report') }}">Loan report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/financial_report') }}">Accounting report</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/company_report') }}">Admin report</a>
                    </li>
                </ul>
            </div>
        </li>        
        @endif                

        @if(Sentinel::inRole('1'))
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#administracion" aria-expanded="false" aria-controls="administracion">
                <i class="fas fa-wallet menu-icon"></i>
                <span class="menu-title">Super admin</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="administracion">
                <ul class="nav flex-column sub-menu">
                    @if(Sentinel::hasAccess('users'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('super_admin/admin') }}">Member control</a>
                    </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" href="#">Permission control</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('super_admin/plans') }}">Plan control</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Paypal setting</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#configuracion" aria-expanded="false" aria-controls="dasboards">
                <i class="fas fa-cogs menu-icon"></i>
                <span class="menu-title">Setting</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="configuracion">
                <ul class="nav flex-column sub-menu">
                    @if(Sentinel::inRole('1'))
                    <li class="nav-item"><a class="nav-link" href="#">General</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">User</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Route</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Method payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Type expenses</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Type penalty</a></li>
                    @endif

                    @if(Sentinel::inRole('2'))
                    <li class="nav-item"><a class="nav-link" href="{{ url('user/profile') }}">Profile</a></li>
                    @endif
                </ul>
            </div>
        </li>
        

        @if(Sentinel::inRole('2'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/collector/data') }}">
                <i class="fas fa-wallet menu-icon"></i>
                <span class="menu-title">Member</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/gpsMap') }}">
                <i class="fas fa-map-marker-alt menu-icon"></i>
                <span class="menu-title">Mapa</span>
            </a>
        </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" href="{{ url('logout') }}">
                <i class="fa fa-sign-out-alt menu-icon"></i>
                <span class="menu-title">Salir</span>
            </a>
        </li>
    </ul>
</nav>