@extends('admin.admin_master')

@section('admin')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Role Page</h4>
                    </div>
                    <div class="card-body">

                    <form action="{{ route('roles.store') }}" method="post" id="myForm">
                    @csrf

                        <div class="row mb-3">
                            <label for="role_name" class="col-sm-2 col-form-label">Role Name</label>
                            <div class="form-group col-sm-10">
                                <input type="text" class="form-control" id="role_name" name="role_name" value="{{ old('role_name') }}">
                                @error('role_name')
                                    <span class="text-danger fw-normal">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Role">

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
                role_name: {
                    required: true,
                },

            },
            messages: {
                role_name: {
                    'required' : 'Please Enter Permission Group Name'
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
