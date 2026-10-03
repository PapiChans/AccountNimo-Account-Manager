@extends('master.master')
@section('content')
@include('vault.modal.vault-modal')
@if ($vault->isEmpty()) 
<div class="card card-body text-center">
    <div class="avatar-sm mx-auto mb-3">
        <div class="avatar-title bg-success-subtle text-success fs-17 rounded">
            <i class="ri-add-line"></i>
        </div>
    </div>
    <h4 class="card-title">Please create new vault</h4>
    <p class="card-text text-muted">You have no vault at this moment. Please create a new one.</p>
    <button class="btn btn-success" onclick="showAddVault()">Create Vault</button>
</div>
@else
    <div class="card card-body">
        <div class="row d-flex align-items-center">
            <div class="col-6 text-start">
                <h4 class="card-title">Select Vault</h4>
            </div>
            <div class="col-6 justify-content-end text-end">
                <button class="btn btn-primary" onclick="showAddVault()">Create Vault</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <h5>Vault List</h5>
        </div>
    </div>
    <div class="row">
        @foreach ($vault as $item)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card card-body">
                    <h6 class="mb-1">{{ $item->name }}</h6>
                    <p class="card-text text-muted">{{ $item->categories->count() }} Categories</p>
                    <div class="btn-group">
                        <button type="button" class="btn btn-success waves-effect waves-light"><i class="ri-eye-line"></i></button>
                        <button type="button" onclick="showEditVault({{$item->id}}, `{{$item->name}}`)" class="btn btn-info btn-icon waves-effect waves-light"><i class="ri-pencil-line"></i></button>
                        @if ($item->categories->count() <= 0)  
                            <button type="button" onclick="deleteVault({{ $item->id }})" class="btn btn-danger btn-icon waves-effect waves-light"><i class="ri-delete-bin-line"></i></button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@push('scripts')
<script>
    function showAddVault() {
        $('#addVaultForm')[0].reset();
        $('#addVaultModal').modal('show');
    }

    $('#addVaultForm').validate({

        rules: {

            name: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },

        },

        messages: {

            name: {
                required: "Name is required"
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
            title: "Add Vault?",
            text: "This will add to the records",
            icon: "question",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#88dd33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, add vault!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#addVaultSubmit').text('Submitting...')
                    $('#addVaultSubmit').prop('disabled', true)
                    form.submit();
                }
            });
        }
    });

    function showEditVault(id, name) {
        $('#editVaultForm')[0].reset();
        $('#edit_id').val(id);
        $('#edit_name').val(name);
        $('#editVaultModal').modal('show');
    }

    $('#editVaultForm').validate({

        rules: {

            edit_name: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },

        },

        messages: {

            edit_name: {
                required: "Name is required"
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
            title: "Update Vault?",
            text: "This will update to the records",
            icon: "question",
            allowOutsideClick: false,
            allowEscapeKey: false,
            showCancelButton: true,
            confirmButtonColor: "#88dd33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, update vault!"
                }).then((result) => {
                if (result.isConfirmed) {
                    $('#editVaultSubmit').text('Updating...')
                    $('#editVaultSubmit').prop('disabled', true)
                    form.submit();
                }
            });
        }
    });

    function deleteVault(id) {

        let url = "{{ route('vault.delete', ':id')}}";
        url = url.replace(':id', id);

        Swal.fire({
        title: "Delete Vault?",
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
                    title: 'Deleting Vault...',
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
                                text: "Vault Deleted successfully!",
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

    });
</script>
@endpush
@endsection