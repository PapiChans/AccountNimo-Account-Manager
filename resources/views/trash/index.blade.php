@extends('master.master')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Trashed Accounts</h5>
                @if ($trash->count() > 1)
                    <button type="button" class="btn btn-danger" onclick="clearTrash()">Clear Trash</button>
                @endif
            </div>
            <hr>
            <div class="table-responsive">
                <table id="trashTable" class="table table-bordered table-striped align-middle" style="width:100%" >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Vault</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trash as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->username ? $item->username : 'Not Available'}}</td>
                                <td>{{$item->category->vault->name}}</td>
                                <td>{{$item->category->name}}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" onclick="restoreAccount({{$item->id}})" class="btn btn-success btn-icon waves-effect waves-light material-shadow-none"><i class=" ri-arrow-go-back-fill"></i></button>
                                        <button type="button" onclick="deleteAccount({{$item->id}})" class="btn btn-danger btn-icon waves-effect waves-light material-shadow-none"><i class="ri-delete-bin-2-fill"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@push('scripts')
    <script>

        function clearTrash() {

            let url = "{{ route('trash.bulkDelete')}}";

            Swal.fire({
            title: "Clear Trash?",
            text: "This will clear up the list.",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, clear it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Clearing Trash...',
                        text: 'Please wait for a while.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 0,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status == 'success'){
                                Swal.fire({
                                    title: "Success!",
                                    text: "Trash Cleared successfully!",
                                    icon: "success"
                                }).then((result) => {
                                    if(result.isConfirmed)
                                    {
                                        location.reload();
                                    }
                                });
                            }
                            else {
                                Swal.fire({
                                    title: "Conflict!",
                                    text: response.text,
                                    icon: "error"
                                })
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            toastr.error('Something went wrong', 'Internal Server Error');
                        }
                    });
                }
            });
        }

        function deleteAccount(id) {

            let url = "{{ route('trash.delete', ':id')}}";
            url = url.replace(':id', id);

            Swal.fire({
            title: "Delete Account?",
            text: "This account will be permanently deleted.",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting Account...',
                        text: 'Please wait for a while.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 0,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status == 'success'){
                                Swal.fire({
                                    title: "Success!",
                                    text: "Account Deleted successfully!",
                                    icon: "success"
                                }).then((result) => {
                                    if(result.isConfirmed)
                                    {
                                        location.reload();
                                    }
                                });
                            }
                            else {
                                Swal.fire({
                                    title: "Conflict!",
                                    text: response.text,
                                    icon: "error"
                                })
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            toastr.error('Something went wrong', 'Internal Server Error');
                        }
                    });
                }
            });
        }

        function restoreAccount(id) {

            let url = "{{ route('trash.restore', ':id')}}";
            url = url.replace(':id', id);

            Swal.fire({
            title: "Restore Account?",
            text: "This account will be restored.",
            icon: "warning",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#88dd33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, restore it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Restoring Account...',
                        text: 'Please wait for a while.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 0,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                    $.ajax({
                        url: url,
                        type: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if(response.status == 'success'){
                                Swal.fire({
                                    title: "Success!",
                                    text: "Account Restored successfully!",
                                    icon: "success"
                                }).then((result) => {
                                    if(result.isConfirmed)
                                    {
                                        location.reload();
                                    }
                                });
                            }
                            else {
                                Swal.fire({
                                    title: "Conflict!",
                                    text: response.text,
                                    icon: "error"
                                })
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            console.log(xhr);
                            toastr.error('Something went wrong', 'Internal Server Error');
                        }
                    });
                }
            });
        }

        $(document).ready(function () {
            const table = new DataTable('#trashTable', {
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": [-1],
                    }
                ],
                responsive: true,
            });
        });
    </script>
@endpush
@endsection