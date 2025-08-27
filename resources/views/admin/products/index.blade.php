@extends('admin.layout.master')

@section('content')

<main class="main-wrapper">
    <div class="main-content">
        
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Products</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product List</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('admin.products.create') }}" class="btn btn-success px-4 raised d-flex gap-2">
                    <i class="material-icons-outlined">add</i>
                    Add New Product
                </a>
                <button type="button" id="bulk-delete-btn" class="btn btn-danger px-4 raised d-flex gap-2"> 
                    <i class="material-icons-outlined">delete</i>
                    Delete Selected Products
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <hr>
                <table id="productTable" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="w-25px">
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" id="select-all" />
                                </div>
                            </th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Sale Price</th>
                            <th>Status</th>
                            <th>Category</th>
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
    var table = $('#productTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        ajax: "{{ route('admin.products.index') }}", 
        columns: [
            {
                data: 'id',
                render: function (data) {
                    return `<input type="checkbox" class="select-row" value="${data}">`;
                },
                orderable: false,
                searchable: false
            },
            { data: 'product_name', name: 'product_name' },
            { data: 'price', name: 'price' },
            { data: 'sale_price', name: 'sale_price' },
            { data: 'product_status', name: 'product_status' },
            { data: 'category', name: 'category_name' },
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
            alert('No products selected.');
            return;
        }

        if(confirm('Are you sure you want to delete selected products?')){
            $.ajax({
                url: "",
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