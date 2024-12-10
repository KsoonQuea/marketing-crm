<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show">

    <div class="c-sidebar-brand d-md-down-none">
        <a class="c-sidebar-brand-full h4" href="#">
            {{ trans('panel.site_title') }}
        </a>
    </div>

    <ul class="c-sidebar-nav">
        <li class="c-sidebar-nav-item">
            <a href="{{ route("admin.home") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>
        @can('user_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/permissions*") ? "c-show" : "" }} {{ request()->is("admin/roles*") ? "c-show" : "" }} {{ request()->is("admin/users*") ? "c-show" : "" }} {{ request()->is("admin/audit-logs*") ? "c-show" : "" }} {{ request()->is("admin/user-teams*") ? "c-show" : "" }} {{ request()->is("admin/user-case-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.userManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('permission_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.permissions.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-unlock-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.permission.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('role_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.roles.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-briefcase c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.role.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.users.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.user.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('audit_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.audit-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/audit-logs") || request()->is("admin/audit-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.auditLog.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_team_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user-teams.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-teams") || request()->is("admin/user-teams/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.userTeam.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('user_case_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.user-case-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/user-case-logs") || request()->is("admin/user-case-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.userCaseLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('case_management_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/case-lists*") ? "c-show" : "" }} {{ request()->is("admin/*") ? "c-show" : "" }} {{ request()->is("admin/*") ? "c-show" : "" }} {{ request()->is("admin/bank-statements*") ? "c-show" : "" }} {{ request()->is("admin/case-director-commitments*") ? "c-show" : "" }} {{ request()->is("admin/*") ? "c-show" : "" }} {{ request()->is("admin/case-documents*") ? "c-show" : "" }} {{ request()->is("admin/case-call-logs*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-archive c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.caseManagement.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('case_list_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.case-lists.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-lists") || request()->is("admin/case-lists/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-folder c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.caseList.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('kyc_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/case-requests*") ? "c-show" : "" }} {{ request()->is("admin/case-management-teams*") ? "c-show" : "" }} {{ request()->is("admin/case-credit-checks*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw far fa-user c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.kyc.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('case_request_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-requests.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-requests") || request()->is("admin/case-requests/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-level-down-alt c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseRequest.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_management_team_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-management-teams.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-management-teams") || request()->is("admin/case-management-teams/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-users c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseManagementTeam.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_credit_check_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-credit-checks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-credit-checks") || request()->is("admin/case-credit-checks/*") ? "c-active" : "" }}">
                                            <i class="fa-fw far fa-credit-card c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseCreditCheck.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('financial_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/case-financials*") ? "c-show" : "" }} {{ request()->is("admin/case-commitments*") ? "c-show" : "" }} {{ request()->is("admin/case-gearings*") ? "c-show" : "" }} {{ request()->is("admin/case-financing-instruments*") ? "c-show" : "" }} {{ request()->is("admin/case-dsrs*") ? "c-show" : "" }} {{ request()->is("admin/case-cashflow-mon-commits*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw fas fa-money-check-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.financial.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('case_financial_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-financials.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-financials") || request()->is("admin/case-financials/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-money-bill c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseFinancial.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_commitment_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-commitments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-commitments") || request()->is("admin/case-commitments/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseCommitment.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_gearing_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-gearings.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-gearings") || request()->is("admin/case-gearings/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-dollar-sign c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseGearing.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_financing_instrument_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-financing-instruments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-financing-instruments") || request()->is("admin/case-financing-instruments/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-money-bill-wave c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseFinancingInstrument.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_dsr_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-dsrs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-dsrs") || request()->is("admin/case-dsrs/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseDsr.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_cashflow_mon_commit_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-cashflow-mon-commits.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-cashflow-mon-commits") || request()->is("admin/case-cashflow-mon-commits/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseCashflowMonCommit.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('bank_statement_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.bank-statements.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/bank-statements") || request()->is("admin/bank-statements/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-address-card c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.bankStatement.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('case_director_commitment_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.case-director-commitments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-director-commitments") || request()->is("admin/case-director-commitments/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-hand-holding-usd c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.caseDirectorCommitment.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('case_check_report_access')
                        <li class="c-sidebar-nav-dropdown {{ request()->is("admin/case-criteria*") ? "c-show" : "" }} {{ request()->is("admin/case-report-recommendations*") ? "c-show" : "" }}">
                            <a class="c-sidebar-nav-dropdown-toggle" href="#">
                                <i class="fa-fw far fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.caseCheckReport.title') }}
                            </a>
                            <ul class="c-sidebar-nav-dropdown-items">
                                @can('case_criterion_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-criteria.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-criteria") || request()->is("admin/case-criteria/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-align-justify c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseCriterion.title') }}
                                        </a>
                                    </li>
                                @endcan
                                @can('case_report_recommendation_access')
                                    <li class="c-sidebar-nav-item">
                                        <a href="{{ route("admin.case-report-recommendations.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-report-recommendations") || request()->is("admin/case-report-recommendations/*") ? "c-active" : "" }}">
                                            <i class="fa-fw fas fa-file-invoice c-sidebar-nav-icon">

                                            </i>
                                            {{ trans('cruds.caseReportRecommendation.title') }}
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @can('case_document_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.case-documents.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-documents") || request()->is("admin/case-documents/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-file-alt c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.caseDocument.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('case_call_log_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.case-call-logs.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-call-logs") || request()->is("admin/case-call-logs/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-check-double c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.caseCallLog.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('setting_access')
            <li class="c-sidebar-nav-dropdown {{ request()->is("admin/countries*") ? "c-show" : "" }} {{ request()->is("admin/states*") ? "c-show" : "" }} {{ request()->is("admin/cities*") ? "c-show" : "" }} {{ request()->is("admin/industry-types*") ? "c-show" : "" }} {{ request()->is("admin/request-types*") ? "c-show" : "" }} {{ request()->is("admin/application-types*") ? "c-show" : "" }} {{ request()->is("admin/case-credit-check-types*") ? "c-show" : "" }} {{ request()->is("admin/banks*") ? "c-show" : "" }} {{ request()->is("admin/criteria*") ? "c-show" : "" }} {{ request()->is("admin/financing-instruments*") ? "c-show" : "" }}">
                <a class="c-sidebar-nav-dropdown-toggle" href="#">
                    <i class="fa-fw fas fa-cogs c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.setting.title') }}
                </a>
                <ul class="c-sidebar-nav-dropdown-items">
                    @can('country_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.countries.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/countries") || request()->is("admin/countries/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-flag c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.country.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('state_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.states.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/states") || request()->is("admin/states/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-map c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.state.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('city_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.cities.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/cities") || request()->is("admin/cities/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-map-marked c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.city.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('industry_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.industry-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/industry-types") || request()->is("admin/industry-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-industry c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.industryType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('request_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.request-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/request-types") || request()->is("admin/request-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-hand-peace c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.requestType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('application_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.application-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/application-types") || request()->is("admin/application-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fab fa-amilia c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.applicationType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('case_credit_check_type_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.case-credit-check-types.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/case-credit-check-types") || request()->is("admin/case-credit-check-types/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-credit-card c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.caseCreditCheckType.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('bank_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.banks.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/banks") || request()->is("admin/banks/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-university c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.bank.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('criterion_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.criteria.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/criteria") || request()->is("admin/criteria/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-align-justify c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.criterion.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('financing_instrument_access')
                        <li class="c-sidebar-nav-item">
                            <a href="{{ route("admin.financing-instruments.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/financing-instruments") || request()->is("admin/financing-instruments/*") ? "c-active" : "" }}">
                                <i class="fa-fw fas fa-money-bill-wave c-sidebar-nav-icon">

                                </i>
                                {{ trans('cruds.financingInstrument.title') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endcan
        @can('director_access')
            <li class="c-sidebar-nav-item">
                <a href="{{ route("admin.directors.index") }}" class="c-sidebar-nav-link {{ request()->is("admin/directors") || request()->is("admin/directors/*") ? "c-active" : "" }}">
                    <i class="fa-fw fas fa-user-circle c-sidebar-nav-icon">

                    </i>
                    {{ trans('cruds.director.title') }}
                </a>
            </li>
        @endcan
        @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="c-sidebar-nav-item">
                    <a class="c-sidebar-nav-link {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'c-active' : '' }}" href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key c-sidebar-nav-icon">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
        @endif
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
