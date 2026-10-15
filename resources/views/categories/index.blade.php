@extends('master.master')
@section('content')
@include('categories.modal.categories-modal')
<div class="card card-body">
    <div class="row d-flex align-items-center">
        <div class="col-12 col-md-6 text-start">
            <h4 class="card-title">Select Categories</h4>
        </div>
        <div class="col-12 col-md-6 justify-content-end text-end">
            <a href="{{ route('vault.index')}}" class="btn btn-info">Back</a>
            @if (!$categories->isEmpty()) 
                <button class="btn btn-primary" onclick="showAddCategory({{$vaultID}})">Create Category</button>
            @endif
        </div>
    </div>
</div>
@if ($categories->isEmpty()) 
<div class="card card-body text-center">
    <div class="avatar-sm mx-auto mb-3">
        <div class="avatar-title bg-success-subtle text-success fs-17 rounded">
            <i class="ri-add-line"></i>
        </div>
    </div>
    <h4 class="card-title">Please create new categories</h4>
    <p class="card-text text-muted">You have no categories at this moment. Please create a new one.</p>
    <button class="btn btn-success" onclick="showAddCategory({{$vaultID}})">Create Category</button>
</div>
@else
    <div class="row">
        @foreach ($categories as $item)
        <div class="col-12 col-md-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="p-3 mt-n3 mx-n3 rounded-top" style="background-color: {{$item->color}}">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h5 class="mb-0 fs-14 text-light">{{ $item->name}}</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <div class="d-flex gap-1 align-items-center my-n2">
                                    <div class="dropdown">
                                        <button class="btn btn-link text-light p-1 mt-n1 py-0 text-decoration-none fs-15 material-shadow-none" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-sm"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </button>
    
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('account.index', $item->id)}}"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> View</a>
                                            <div class="dropdown-item" style="cursor: pointer;" onclick="showEditCategory({{ $item->id }}, `{{$item->name}}`, '{{$item->color}}')"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Edit</div>
                                            <div class="dropdown-divider"></div>
                                            <div class="dropdown-item" style="cursor: pointer;" onclick="deleteCategory({{$item->id}})"><i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Delete</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-3">
                        <div class="row gy-3">
                            <div class="col-6">
                                <div>
                                    <p class="text-muted mb-1">Accounts</p>
                                    <h5 class="fs-14">{{ $item->accounts->count() }} Account{{ $item->accounts->count() != 1 ? 's' : ''}}</h5>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <p class="text-muted mb-1">Created at</p>
                                    <h5 class="fs-14">{{ Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card body -->
            </div>
        </div>
        @endforeach
    </div>
@endif
@push('scripts')
    <script>
        function showAddCategory(vaultID) {
            $('#addCategoryForm')[0].reset();
            $('#add_vault_id').val(vaultID);
            $('#addCategoryModal').modal('show');
        }

        $('#addCategoryForm').validate({

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
                title: "Add Category?",
                text: "This will add to the records",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#88dd33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, add category!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $('#addCategorySubmit').text('Submitting...')
                        $('#addCategorySubmit').prop('disabled', true)
                        form.submit();
                    }
                });
            }
        });

        function showEditCategory(id, name, color) {
            $('#editCategoryForm')[0].reset();
            $('#edit_id').val(id);
            $('#edit_name').val(name);
            $('#edit_color').val(color);
            $('#editCategoryModal').modal('show');
        }

        $('#editCategoryForm').validate({

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
                title: "Update Category?",
                text: "This will update to the records",
                icon: "question",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: true,
                confirmButtonColor: "#88dd33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, update category!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $('#editCategorySubmit').text('Updating...')
                        $('#editCategorySubmit').prop('disabled', true)
                        form.submit();
                    }
                });
            }
        });

        function deleteCategory(id) {

            let url = "{{ route('category.delete', ':id')}}";
            url = url.replace(':id', id);

            Swal.fire({
            title: "Delete Category?",
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
                        title: 'Deleting Category...',
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
                                    text: "Category Deleted successfully!",
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
    </script>
@endpush
@endsection