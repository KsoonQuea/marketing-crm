@forelse ($caseList->director_commitment as $director_commitment)
    @if (isset($director_commitment->director))
        <h5 class="tab-pane-header">
            {{ $director_commitment->director->name }}
        </h5> &nbsp;
        <div class='card'>
            <div class="card-body">
                <div class="row">
                    <div class="director-profile col-3 text-center">
                        <img class="img-90 rounded-circle" src="{{ asset('assets/images/dashboard/1.png') }}" alt="User Profile" />
                        <p class="title">
                            {{ $director_commitment->director->name ?? '-' }}
                        </p>
                        <p class="content">
                            {{ $director_commitment->director->ic ?? '-' }}
                        </p>
                    </div>
                    <div class="col-4">
                        <div class="director-text-container">
                            <p class="title">Email</p>
                            <p class="content">
                                {{ $director_commitment->director->email ?? '-' }}
                            </p>
                        </div>
                        <div class="director-text-container">
                            <p class='title'>Phone Number</p>
                            <p class='content'>
                                {{ $director_commitment->director->phone ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <div class='col-5'>
                        <div class="director-text-container">
                            <p class='title'>Address</p>
                            <p class='content'>
                                {{ $director_commitment->director->address_1 . ' ' . $director_commitment->director->address_2 }}
                            </p>
                        </div>
                        <div class='row'>
                            <div class="col-6 director-text-container">
                                <p class='title'>Gender</p>
                                <p class='content'>
                                    {{ App\Models\Director::GENDER_SELECT[$director_commitment->director->gender] ?? '' }}
                                </p>
                            </div>
                            <div class="col-6 director-text-container">
                                <p class='title'>Marriage Status</p>
                                <p class='content'>
                                    {{ App\Models\Director::MARITAL_STATUS_SELECT[$director_commitment->director->maritial_status] ?? '' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @if (isset($director_commitment->director->case))
                    <div class='row'>
                        <div class="col-12" style='padding:0px;'>
                            <button class="accordion">Case List</button>
                            <div class="panel">
                                <table
                                    class="table table-bordered align-items-center table-sm">
                                    <tbody>
                                    <tr>
                                        <th>#</th>
                                        <th>Company Name</th>
                                        <th>Case Code</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    @forelse ($director_commitment->director->case as $case)
                                        <tr>
                                            <td>{{ $case->id }}</td>
                                            <td>{{ $case->company_name ?? '-' }}
                                            </td>
                                            <td><a
                                                    href="{{ route('admin.case-lists.show', ['case_list' => $case->id]) }}">{{ $case->case_code }}</a>
                                            </td>
                                            <td>{{ $case->created_at ?? '-' }}
                                            </td>
                                            <td>{{ App\Models\CaseList::STATUS_SELECT[$case->status] ?? '-' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No Result
                                                Found.
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    @endif
    @else
        <h5 class="tab-pane-header">Directors</h5> &nbsp;
        <div class='card'>
            <div class="card-body">
                <p>No Director Found</p>
            </div>
        </div>
    @endif
@empty
    <h5 class="tab-pane-header">Directors</h5> &nbsp;
    <div class='card'>
        <div class="card-body">
            <p>No Director Found</p>
        </div>
    </div>
@endforelse
