@extends('admin.admin_master')

@section('admin')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Supplier Page</h4>
                    </div>
                    <div class="card-body">


                        <form action="{{ route('admin.update') }}" method="post" id="myForm">
                            @csrf

                            <input type="hidden" name="id" value="{{ $admin->id }}">

                            <div class="row mb-3">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="form-group col-sm-10">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $admin->username }}">
                                </div>
                            </div>

                                <div class="row mb-3">
                                    <label for="name" class="col-sm-2 col-form-label">Name</label>
                                    <div class="form-group col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                                    <div class="form-group col-sm-10">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                                    <div class="form-group col-sm-10">
                                        <input type="password" class="form-control" id="password" name="password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                                    <div class="form-group col-sm-10">
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                                    <div class="form-group col-sm-10">
                                        <select name="role[]" class="form-select" id="" multiple>
                                            <option value="">Select Role</option>
                                            @foreach($roles as $role)
                                                <option {{ ($hasRole == $role->name) ? 'selected' : '' }} value="{{ $role->name }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Controller">

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
                username: {
                    required: true,
                },
                name: {
                    required: true,
                },
                email: {
                    required: true,
                },
                role: {
                    required: true,
                },

            },
            messages: {
                username: {
                    'required' : 'Please Enter Your User Name'
                },
                name: {
                    'required' : 'Please Enter Your Name'
                },
                email: {
                    'required' : 'Please Enter Your Email'
                },
                role: {
                    'required' : 'Please Select Your Role'
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
