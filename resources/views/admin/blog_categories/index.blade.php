
@extends('admin.layout.master')

@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Blog Categories</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog Categories</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-success px-4 raised d-flex gap-2">
                        <i class="material-icons-outlined">add</i>
                        Add New Category
                    </a>
                </div>
                <div class="btn-group">
                    <button type="submit" id="bulk-delete-btn" class="btn btn-danger px-4 raised d-flex gap-2"> 
                        <i class="material-icons-outlined">delete</i>
                        Delete Selected Category
                    </button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card-body">
            <div class="table-responsive">
                <hr>
                <table id="categoryTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="select-all" />
                                </div>
                            </th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</main>
<!--end main wrapper--> 
@endsection

@push('scripts')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="{{ asset('admin_assets/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>

<script>
$(document).ready(function () {

    // Initialize DataTable
    var table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        columnDefs: [
            { targets: 0, width: "10px" },
            { targets: 1, width: "150px" },
            { targets: 2, width: "200px" },
            { targets: 3, width: "120px" },
            { targets: 4, width: "190px" }
        ],
        ajax: "{{ route('admin.blog-categories.index') }}",
        columns: [
            {
                data: 'id',
                render: function (data) {
                    return `<input type="checkbox" class="select-row" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'category_name', name: 'category_name' },
            { data: 'category_small_description', name: 'category_small_description' }, 
            { data: 'image', name: 'image', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Select/Deselect all rows
    $(document).on('click', '#select-all', function () {
        $('.select-row').prop('checked', this.checked);
    });

    $(document).on('click', '.select-row', function () {
        if ($('.select-row:checked').length === $('.select-row').length) {
            $('#select-all').prop('checked', true);
        } else {
            $('#select-all').prop('checked', false);
        }
    });

    // Bulk Delete
    $('#bulk-delete-btn').on('click', function () {
        var ids = $('.select-row:checked').map(function () {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            alert('No categories selected.');
            return;
        }

        if (confirm('Are you sure you want to delete selected categories?')) {
            $.ajax({
			    url: "{{ route('admin.blog-categories.bulkDelete') }}",
			    method: 'POST',
			    data: {
			        ids: ids,
			        _token: '{{ csrf_token() }}',
			        _method: 'DELETE'
			    },
			    success: function (response) {
			        alert(response.success);
			        $('#select-all').prop('checked', false);
			        table.ajax.reload();
			    },
			    error: function () {
			        alert('Something went wrong!');
			    }
			});
        }
    });

});
</script>
@endpush