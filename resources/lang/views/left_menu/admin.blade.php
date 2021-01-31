<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="profile">
            <div class="profile-wrapper">
                <i class="far fa-user-circle" style="font-size: 2.5em;"></i>
                <!---style="width:50px; height:50px;"--->
                <!---<img src="{{ asset('assets/new_theme/images/usuario.png') }}" alt="profile">--->
                <div class="profile-details">
                    <p class="name">Bienvenid@</p>
                    <p class="name"><strong>{{ Sentinel::getUser()->first_name }} {{ Sentinel::getUser()->last_name }}</strong></p>
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
                    <span class="menu-title">Clientes</span>
                </a>
            </li>
            @endif

            @if(Sentinel::hasAccess('loans'))
            <li class="nav-item @if(Request::is('loan/data')) active @endif">
                <a class="nav-link" href="{{ url('loan/data') }}">
                    <i class="fab fa-leanpub menu-icon"></i>
                    <span class="menu-title">Prestamos</span>
                </a>
            </li>
            <li class="nav-item @if(Request::is('loan/data')) active @endif">
                <a class="nav-link" href="{{ url('repayment/data') }}">
                    <i class="fab fa-leanpub menu-icon"></i>
                    <span class="menu-title">Pagos</span>
                </a>
            </li>            
            <!---
            <li class="nav-item @if(Request::is('loan/loan_product/*')) active @endif">
                <a class="nav-link" href="{{ url('loan/loan_product/data') }}">
                    <i class="fab fa-leanpub menu-icon"></i>
                    <span class="menu-title">Rutas</span>
                </a>
            </li>
            --->
            <!---
            <li class="nav-item @if(Request::is('loan/loan_repayment_method/*')) active @endif">
                <a class="nav-link" href="{{ url('loan/loan_repayment_method/data') }}">
                    <i class="fab fa-leanpub menu-icon"></i>
                    <span class="menu-title">Loan Payment Method</span>
                </a>
            </li>--->
            @endif
        <!--
        <li class="nav-item">
            <a class="nav-link" href="{{ url('repayment/data') }}">
                <i class="fas fa-money-bill-wave-alt menu-icon"></i>
                <span class="menu-title">Pagos</span>
            </a>
        </li>--->
        <li class="nav-item @if(Request::is('expense/*')) active @endif">
            <a class="nav-link" href="{{ url('expense/data') }}">
                <i class="fas fa-receipt menu-icon"></i>
                <span class="menu-title">Gastos</span>
            </a>
        </li> 
        <!---
        <li class="nav-item @if(Request::is('other_income/*')) active @endif">
            <a class="nav-link" href="{{ url('other_income/data') }}">
                <i class="fas fa-file-invoice-dollar menu-icon"></i>
                <span class="menu-title">Ingresos</span>
            </a>
        </li>--->    
        <li class="nav-item @if(Request::is('capital/*')) active @endif">
            <a class="nav-link" href="{{ url('capital/data') }}">
                <i class="fas fa-calculator menu-icon"></i>
                <span class="menu-title">Capital</span>
            </a>
        </li>
        @endif        
        @if(Sentinel::inRole('2'))
        <li class="nav-item @if(Request::is('accounting/*')) active @endif ">
            <a class="nav-link" data-toggle="collapse" href="#contabilid" aria-expanded="false" aria-controls="contabilid">
                <i class="fas fa-wallet menu-icon"></i>
                <span class="menu-title">Contabilidad</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="contabilid">
                <ul class="nav flex-column sub-menu">
                    <!---@if(Sentinel::inRole('1'))
                    <li class="nav-item"><a class="nav-link" href="{{ url('chart_of_account/data') }}">Account list</a></li>
                    @endif--->
                    
                    <li class="nav-item"><a class="nav-link" href="{{ url('accounting/journal') }}">Diario general</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('accounting/ledger') }}">Balance de cuentas</a></li>
                    <!---<li class="nav-item"><a class="nav-link" href="{{ url('accounting/manual_entry/create') }}">Entrada manual</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('capital/data') }}">Capital</a></li>--->
                    
                </ul>
            </div>
        </li> 
        @endif
        <!---
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
                        <a class="nav-link" href="{{ url('report/borrower_report') }}">Reportes de clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/loan_report') }}">Reportes de prestamos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/financial_report') }}">Reportes contables</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/company_report') }}">Reportes administrativos</a>
                    </li>
                </ul>
            </div>
        </li>        
        @endif    --->            


        @if(Sentinel::inRole('2') && Sentinel::hasAccess('reports'))        
        <li class="nav-item @if(Request::is('report/*')) active @endif">
            <a class="nav-link" data-toggle="collapse" href="#reportes" aria-expanded="false" aria-controls="reportes">
                <i class="fas fa-book menu-icon"></i>
                <span class="menu-title">Reportes</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="reportes">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/financial_report/income_statement') }}">Beneficios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/loan_report/disbursed_loans') }}">Prestamos realizados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('report/loan_report/arrears_report') }}">Prestamos en atraso</a>
                    </li>
                </ul>
            </div>
        </li>        
        @endif
        
        
        @if(Sentinel::inRole('1'))
        @if(Sentinel::hasAccess('users'))        
        <li class="nav-item">
            <a class="nav-link" href="{{ url('super_admin/admin') }}">
                <i class="fa fa-user menu-icon"></i>
                <span class="menu-title">Membresias</span>
            </a>
        </li>    
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{ url('super_admin/plans') }}">
                <i class="fa fa-user menu-icon"></i>
                <span class="menu-title">Planes de pagos</span>
            </a>
        </li> 
        @endif

        <li class="nav-item  @if(Request::is('loan/loan_product/*')) active @endif">
            <a class="nav-link" data-toggle="collapse" href="#configuracion" aria-expanded="false" aria-controls="dasboards">
                <i class="fas fa-cog menu-icon"></i>
                <span class="menu-title">Configuracion</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="configuracion">
                <ul class="nav flex-column sub-menu">
                    @if(Sentinel::inRole('1'))
                    <li class="nav-item"><a class="nav-link" href="#">CRON sistema</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('loan/loan_repayment_method/data') }}">Metodos de pagos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('chart_of_account/data') }}">Cuentas contables</a></li>
                    @endif

                    @if(Sentinel::inRole('2'))
                    <li class="nav-item"><a class="nav-link" href="{{ url('user/profile') }}">Perfil administrador</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('loan/loan_product/data') }}">Rutas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('user/collector/data') }}">Cobrador</a></li>                                        
                    @endif
                </ul>
            </div>
        </li>
        
        @if(Sentinel::inRole('1'))
        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/profile') }}">
                <i class="fa fa-user menu-icon"></i>
                <span class="menu-title">Perfil</span>
            </a>
        </li> 
        @endif
        
        @if(Sentinel::inRole('2'))
<!---        <li class="nav-item">
            <a class="nav-link" href="{{ url('user/collector/data') }}">
                <i class="fas fa-wallet menu-icon"></i>
                <span class="menu-title">Cobradores</span>
            </a>
        </li>
--->
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