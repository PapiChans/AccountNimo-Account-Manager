@extends('master.master')
@section('content')
@include('account_link.modal.account_link_modal')
<link rel="stylesheet" href="{{ asset('assets/libs/tomselect/tom-select.css') }}">
<div class="card card-body">
    <div class="row d-flex align-items-center">
        <div class="col-12 col-md-6 text-start">
            <h4 class="card-title">Account Link</h4>
        </div>
        <div class="col-12 col-md-6 justify-content-end text-end">
            <a href="{{ route('account.index', $account->category_id)}}" class="btn btn-info">Back</a>
            <button class="btn btn-primary" onclick="showAddAccountLink({{$account->id}})">Add Link</button>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col">
            <h5 class="card-title">{{$account->name}}</h5>
            <p class="text-muted">Account Name</p>
        </div>
        <div class="col">
            <h5 class="card-title">{{$account->username ?? 'Not Available'}}</h5>
            <p class="text-muted">Username</p>
        </div>
    </div>
</div>
<div class="card card-body mt-2">
    <h5 class="card-title mb-0">Link Table</h5>
    <div class="table table-responsive">
        <table id="myTable" class="table table-bordered table-striped align-middle" style="width:100%" >
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($account->account_link as $item)
                    <tr>
                        <td>{{$item->linkedAccount->name}}</td>
                        <td>{{$item->linkedAccount->username ?? 'Not Available'}}</td>
                        <td>
                            @switch($item->link_type)
                                @case('registered_with')
                                    Registered With
                                    @break
                                @case('login_via')
                                    Login Via
                                    @break
                                @default
                                    Unknown
                            @endswitch                                
                        </td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <button type="button" onclick="deleteAccountLink({{ $account->id}}, {{$item->id}})"
                                class="btn btn-danger btn-icon waves-effect waves-light"
                                    title="Delete Link">
                                    <i class="ri-delete-bin-5-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card card-body mt-2">
    <h5 class="card-title mb-0">Other Linked Accounts</h5>
    <div class="table table-responsive">
        <table id="otherTable" class="table table-bordered table-striped align-middle" style="width:100%" >
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Vault</th>
                    <th>Category</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($otherAccount as $item)
                    <tr>
                        <td>{{$item->account->name}}</td>
                        <td>{{$item->account->username ?? 'Not Available'}}</td>
                        <td>{{$item->account->category->vault->name}}</td>
                        <td>{{$item->account->category->name}}</td>
                        <td>
                            @switch($item->link_type)
                                @case('registered_with')
                                    Registered With
                                    @break
                                @case('login_via')
                                    Login Via
                                    @break
                                @default
                                    Unknown
                            @endswitch                                
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@push('scripts')
    <script src="{{ asset('assets/libs/tomselect/tom-select.complete.min.js')}}"></script>
    <script>
        
        function showAddAccountLink(accountID) {
            $('#addAccountLinkForm')[0].reset();
            $('#account_id').val(accountID);
            $('#addLinkModal').modal('show');
        }

        $('#addAccountLinkForm').validate({

            rules: {

                linked_account_id: {
                    required: true,
                },  

                link_type: {
                    required: true,
                },  

            },

            messages: {

                link_account_id: {
                    required: "Please select an account"
                },

                link_type: {
                    required: "Please select a link type"
                },

            },

            errorElement: 'div',
            errorClass: 'invalid-feedback',

            highlight: function (element) {
                $(element).addClass('is-invalid');
            },

            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },

            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },

            submitHandler: function (form) {
                // alert('Validation Passed');

                Swal.fire({
                title: "Add Account Link?",
                text: "This will add to the records",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#88dd33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, add link!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addAccountLinkSubmit').text('Submitting...')
                        $('#addAccountLinkSubmit').prop('disabled', true)
                        form.submit();
                    }
                });
            }
        });

        function deleteAccountLink(accountID,id) {

            let url = "{{ route('account.link.delete', [':account_id', ':id']) }}";
            url = url.replace(':account_id', accountID).replace(':id', id);

            Swal.fire({
            title: "Delete Account Link?",
            text: "This cannot be undone.",
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
                        title: 'Deleting Link...',
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
                                    text: "Account Link Deleted successfully!",
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

        $(document).ready(function () {
            const table = new DataTable('#myTable', {
                "columnDefs": [
                    {
                        "orderable": false,
                        "targets": [-1],
                    }
                ],
                responsive: true,
            });

            const table2 = new DataTable('#otherTable', {
                responsive: true,
            });

            new TomSelect('#linked_account_id', {
                create: false,
                allowEmptyOption: true,
                placeholder: 'Search account...',
                maxOptions: null,
            });
        });
    </script>
@endpush
@endsection