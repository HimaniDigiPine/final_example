@extends('admin.layout.master')

@section('content')

<!--start main wrapper-->
<main class="main-wrapper">
    <div class="main-content">
        
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Services</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Services</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.services.create') }}" class="btn btn-success px-4 raised d-flex gap-2">
                        <i class="material-icons-outlined">add</i>
                        Add New Service
                    </a>
                </div>
                <div class="btn-group">
                    <button type="submit" id="bulk-delete-btn" class="btn btn-danger px-4 raised d-flex gap-2"> 
                        <i class="material-icons-outlined">delete</i>
                        Delete Selected Service
                    </button>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card-body">
            <div class="table-responsive">
                <hr>
                <table id="serviceTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="select-all" />
                                </div>
                            </th>
                            <th>Service Name</th>
                            <th>Service Icon</th>
                            <th>Service Image</th>
                            <th>Service Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
</main>
<!--end main wrapper--> 

@push('scripts')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

<script src="{{ asset('admin_assets/plugins/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>


<script>
$(document).ready(function () {

    var table = $('#serviceTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: "{{ route('admin.services.index') }}",
        columnDefs: [
            { targets: 0, width: "10px" },
            { targets: 1, width: "150px" },
            { targets: 2, width: "120px" },
            { targets: 3, width: "120px" },
            { targets: 4, width: "250px" },
            { targets: 5, width: "180px" }
        ],
        columns: [
            {
                data: 'id',
                render: function(data) {
                    return `<input type="checkbox" class="select-row" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'service_name', name: 'service_name' },           
            { data: 'feature_image', name: 'feature_image', orderable: false, searchable: false  },         
            { data: 'service_image', name: 'service_image', orderable: false, searchable: false },         
            { data: 'service_description', name: 'service_description' }, 
            { data: 'action', name: 'action', orderable: false, searchable: false } 
        ]
    });

    // Select/Deselect all rows
    $('#select-all').on('click', function () {
        $('.select-row').prop('checked', this.checked);
    });

    $(document).on('click', '.select-row', function () {
        $('#select-all').prop('checked', $('.select-row:checked').length === $('.select-row').length);
    });

    // Bulk Delete
    $('#bulk-delete-btn').on('click', function () {
        var ids = $('.select-row:checked').map(function () {
            return $(this).val();
        }).get();

        if (ids.length === 0) {
            alert('No services selected.');
            return;
        }

        if (confirm('Are you sure you want to delete selected services?')) {
            $.ajax({
			    url: "{{ route('admin.services.bulkDelete') }}",
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