@extends('master.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Logs Filter</h5>
            <form action="{{ route('logs.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-4 col-8">
                        <label for="filter">Month and Year</label>
                        <div class="input-group">
                            <input type="text" id="month_year" class="form-control" placeholder="Select Month and Year" readonly>
                            <input type="hidden" name="month_year" id="month_year_value" value="{{ $monthYear }}">
    
                            <button type="submit" class="btn btn-outline-primary" id="month_year_btn"><i class="ri-calendar-line"></i> Filter</button>
                        </div>
                    </div>
                    <div class="col-auto d-flex align-items-end">
                        <button type="button" class="btn btn-primary" id="resetBtn">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Activity Logs</h5>

                @if ($monthYear)
                    <span class="text-muted">
                        {{ \Carbon\Carbon::createFromFormat('Y-m', $monthYear)->format('F Y') }}
                    </span>
                @else
                    <span class="text-muted">
                        All Logs
                    </span>
                @endif

            </div>
            <div class="table-responsive">
                <table id="logsTable" class="table table-info table-bordered table-striped align-middle" style="width:100%" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($logs as $item)
                         <tr>
                            <td>{{$count++}}</td>
                            <td>{{$item->action}}</td>
                            <td>{{$item->description}}</td>
                            <td>{{$item->ip_address}}</td>
                            <td>{{$item->created_at?->format('M d, Y h:i A')}}</td>
                         </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#month_year').datepicker({
                format: 'MM yyyy',
                minViewMode: 1,
                autoclose: true,
                orientation: 'bottom',
            }).on('changeDate', function (e) {
                const date = e.date;
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');

                $('#month_year_value').val(year + '-' + month);
            });

            $('#logsTable').DataTable({
                order: [['desc']],
            });

            $('#resetBtn').on('click', function () {
                window.location.href = "{{route('logs.index')}}";
            });
        });
    </script>
@endpush