@extends('admin.admin_master')

@section('admin')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Product Page</h4>
                    </div>
                    <div class="card-body">


                    <form action="{{ route('product.update') }}" method="post" id="myForm">
                    @csrf

                    <input type="hidden" name="id" value="{{ $product->id }}">

                        <div class="row mb-3">
                            <label for="name" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="form-group col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="supplier_id" class="col-sm-2 col-form-label">Supplier Name</label>
                            <div class="form-group col-sm-10">
                                <select name="supplier_id" id="supplier_id" class="form-select">
                                    <option selected value="">Select a Supplier</option>
                                    @foreach($supplier as $key => $item)
                                        <option {{ ($item->id == $product->supplier_id ) ? 'selected' : '' }}  value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="unit_id" class="col-sm-2 col-form-label">Unit Name</label>
                            <div class="form-group col-sm-10">
                                <select name="unit_id" id="unit_id" class="form-select">
                                    <option selected value="">Select a Unit</option>
                                    @foreach($unit as $key => $item)
                                        <option {{ ($item->id == $product->unit_id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="category_id" class="col-sm-2 col-form-label">Category Name</label>
                            <div class="form-group col-sm-10">
                                <select name="category_id" id="category_id" class="form-select">
                                    <option selected value="">Select a Category</option>
                                    @foreach($category as $key => $item)
                                        <option {{ ($item->id == $product->category_id) ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Product">

                    </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){

        $("#myForm").validate({
            rules: {
                name: {
                    required: true,
                },
                supplier_id: {
                    required: true,
                },
                unit_id: {
                    required: true,
                },
                category_id: {
                    required: true,
                },

            },
            messages: {
                name: {
                    'required' : 'Please Enter Your Product Name'
                },
                supplier_id: {
                    'required' : 'Please Select One Supplier'
                },
                unit_id: {
                    'required' : 'Please Select One Unit'
                },
                category_id: {
                    'required' : 'Please Select One Category'
                },

            },
            errorElement: 'span',
            errorPlacement: function(error, element){
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            }
        });

    });

</script>

@endsection
