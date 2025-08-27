@extends('admin.layout.master')

@section('content')

<main class="main-wrapper">
    <div class="main-content">
        
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Product</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Category</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('admin.productscategories.create') }}" class="btn btn-success px-4 raised d-flex gap-2">
                    <i class="material-icons-outlined">add</i>
                    Add New Product Category
                </a>
                <button type="button" id="bulk-delete-btn" class="btn btn-danger px-4 raised d-flex gap-2"> 
                    <i class="material-icons-outlined">delete</i>
                    Delete Selected Product Category
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <hr>
                <table id="productCategoryTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="select-all" />
                                </div>
                            </th>
                            <th>Category Name</th>
                            <th>Status </th>
                            <th>Action</th>
                        </tr>                   
                    </thead>
                </table>
            </div>
        </div>

    </div>
</main>

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
    var table = $('#productCategoryTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        columnDefs: [
            { targets: 0, width: "10px" },
            { targets: 1, width: "150px" },
            { targets: 2, width: "200px" },
            { targets: 3, width: "120px" }
        ],
        ajax: "{{ route('admin.productscategories.index') }}", // ✅ fixed
        columns: [
            {
                data: 'id',
                render: function (data) {
                    return `<input type="checkbox" class="select-row" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'name', name: 'name' }, 
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    // Select/Deselect all rows
    $(document).on('click', '#select-all', function () {
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

        if(ids.length === 0){
            alert('No categories selected.');
            return;
        }

        if(confirm('Are you sure you want to delete selected categories?')){
            $.ajax({
                url: "{{ route('admin.productscategories.bulkDelete') }}",
                type: 'DELETE',
                data: {
                    ids: ids,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response){
                    alert(response.message);
                    $('#select-all').prop('checked', false);
                    table.ajax.reload();
                },
                error: function(){
                    alert('Something went wrong!');
                }
            });
        }
    });
});
</script>
@endpush
