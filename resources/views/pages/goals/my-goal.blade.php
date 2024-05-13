<x-app-layout>
    @section('title', 'Goals')
    <x-slot name="content">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h1 class="h2">Your Goals</h1>
            <a href="{{ route('goals.form', Auth::user()->employee_id) }}" class="btn btn-primary px-4 shadow">Create Goals</a>
        </div>
        <form action="{{ route('goals') }}" method="GET">
            <div class="d-flex align-items-end">
                <div class="form-group mr-3">
                    <label for="filterYear">Year</label>
                    <select name="filterYear" id="filterYear" class="form-control border-secondary" @style('width: 120px')>
                        <option value="">- select -</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary">Apply</button>
                </div>
            </div>
        </form>
        @foreach ($data as $row)
        @php
            // Assuming $dateTimeString is the date string '2024-04-29 06:52:40'
            $year = date('Y', strtotime($row->request->created_at));
            $formData = json_decode($row->request->goal['form_data'], true);
        @endphp
        <div class="row">
            <div class="col-md-12">
              <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Goals {{ $year }}</h6>
                    @if ($row->request->status == 'Pending' && count($row->request->approval) == 0)
                        <a href="{{ route('goals.edit', $row->request->goal->id) }}" class="dropdown"><i class="fas fa-edit"></i></a>
                    @endif
                    {{-- <div class="dropdown no-arrow">
                        <a href="#" id="dropdownMenuLink" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i></a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            @if ($row->request->status == 'Pending' && count($row->request->approval) == 0)
                                <a href="{{ route('goals.edit', $row->request->goal->id) }}" class="dropdown-item">Edit</a>
                            @endif
                        </div>
                    </div> --}}
                </div>
                <div class="card-body">
                    @if ($formData)
                    @foreach ($formData as $index => $data)
                    <div class="row mb-3 p-2">
                        <div class="col-lg col-sm-12 p-2">
                            <div class="form-group">
                                <label class="font-weight-bold">KPI {{ $index + 1 }}</label>
                                <p>{{ $data['kpi'] }}</p>
                            </div>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <div class="form-group">
                                <label class="font-weight-bold">Target</label>
                                <p>{{ $data['target'] }}</p>
                            </div>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <div class="form-group">
                                <label class="font-weight-bold">UoM</label>
                                <p>{{ $data['uom'] }}</p>
                            </div>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <div class="form-group">
                                <label class="font-weight-bold">Type</label>
                                <p>{{ $data['type'] }}</p>
                            </div>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <div class="form-group">
                                <label class="font-weight-bold">Weightage</label>
                                <p>{{ $data['weightage'] }}%</p>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    @endforeach
                    @else
                        <p>No form data available.</p>
                    @endif 
                </div>
                <div class="card-footer">
                    <div class="row p-2">
                        <div class="col-lg col-sm-12 p-2">
                            <label class="font-weight-bold">Initiated By :</label>
                            <p>{{ $row->request->initiated->name.' ('.$row->request->initiated->employee_id.')' }}</p>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <label class="font-weight-bold">Initiated On :</label>
                            <p>{{ $row->request->created_at }}</p>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <label class="font-weight-bold">Last Updated On :</label>
                            <p>{{ $row->request->updated_at }}</p>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <label class="font-weight-bold">Adjusted By :</label>
                            <p>{{ $row->request->adjusted ? $row->request->adjusted->name : '-' }}</p>
                        </div>
                        <div class="col-lg col-sm-12 p-2">
                            <label class="font-weight-bold">Status :</label>
                            <div>
                                <a href="#" id="approval{{ $row->request->employee_id }}" data-id="{{ $row->request->employee_id }}" class="badge {{ $row->request->goal->form_status == 'Draft' ? 'badge-secondary' : ($row->request->status === 'Approved' ? 'badge-success' : 'badge-warning')}} badge-pill px-3 py-2">{{ $row->request->goal->form_status == 'Draft' ? 'Draft': ($row->request->status == 'Pending' ? 'Waiting for approval' : $row->request->status) }}</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            </div>
        </div>
        @endforeach
    </div>
    
    </x-slot>
</x-app-layout>
<script src="{{ asset('js/goal-approval.js') }}"></script>