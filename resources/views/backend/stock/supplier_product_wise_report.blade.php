@extends('admin.admin_master')

@section('admin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Supplier and Product Wise Report</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                <li class="breadcrumb-item active">Data Tables</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12 text-center">

                                    <input type="radio" name="supplier_product_wise" value="supplier_wise"
                                        class="search_value" id="supplier_wise" >
                                    <label for="supplier_wise" class="form-label">Supplier Wise Report</label>

                                        &nbsp;&nbsp;&nbsp;

                                    <input type="radio" name="supplier_product_wise" value="product_wise"
                                        class="search_value" id="product_wise" >
                                    <label for="product_wise" class="form-label">Product Wise Report</label>

                                </div>
                            </div> {{-- end row --}}

                            <br/>

                            {{-- Supplier Wise --}}
                            <div class="show_supplier" style="display:none">
                                <form action="{{ route('supplier.wise.pdf') }}" method="GET" id="myForm" target="_blank">
                                    <div class="row">
                                        <div class="col-sm-8 form-group">
                                            <label for="supplier_id" class="form-label">Supplier Name</label>
                                            <select name="supplier_id" id="supplier_id" class="form-select select2">
                                                <option selected value="">Select a Supplier</option>
                                                @foreach ($supplier as $key => $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-4" style="padding-top: 28px;">
                                            <label for=""></label>
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                            {{-- Product Wise --}}
                            <div class="show_product" style="display:none">
                                <form action="{{ route('product.wise.pdf') }}" method="GET" id="productForm" target="_blank">
                                    <div class="row">

                                        <div class="col-md-5">
                                            <div class="md-3 form-group">
                                                <label for="category_id" class="form-label">Category Name</label>
                                                <select name="category_id" id="category_id" class="form-select select2">
                                                    <option class="bg-dark" selected value="">Select a Category</option>
                                                    @foreach ($category as $key => $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="md-3 form-group">
                                                <label for="product_id" class="form-label">Product Name</label>
                                                <select name="product_id" id="product_id" class="form-select select2">
                                                    {{-- <option selected value="">Select a Product</option> --}}

                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-2" style="padding-top: 28px;">
                                            <label for=""></label>
                                            <button type="submit" class="btn btn-primary">Search</button>
                                        </div>

                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {

            $("#myForm").validate({
                rules: {
                    category_id: {
                        required: true,
                    },
                    product_id: {
                        required: true,
                    },
                },
                messages: {
                    category_id: {
                        'required': 'Please Select Category'
                    },
                    product_id: {
                        'required': 'Please Select Product'
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

        });
    </script>

    <script>
        $(document).on('change', '.search_value', function() {
            var search_value = $(this).val();

            if (search_value == "supplier_wise") {
                $(".show_supplier").show();
            } else {
                $(".show_supplier").hide();
            }

        });
    </script>

<script>
    $(document).on('change', '.search_value', function() {
        var search_value = $(this).val();

        if (search_value == "product_wise") {
            $(".show_product").show();
        } else {
            $(".show_product").hide();
        }

    });
</script>

<script>
    $(function() {
        $(document).on('change', '#category_id', function() {

            var category_id = $(this).val();

            $.ajax({
                url: "{{ route('get-product') }}",
                type: "GET",
                data: {
                    category_id: category_id
                },
                success: function(data) {
                    var html = '<option value="">Select a Product</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.id + '">' + v.name +
                            '</option>';
                    });
                    $('#product_id').html(html);
                }
            });

        });
    });
</script>


@endsection
