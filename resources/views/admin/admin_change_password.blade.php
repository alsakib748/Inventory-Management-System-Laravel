@extends('admin.admin_master')

@section('admin')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Change Password Page</h4>
                    </div>
                    <div class="card-body">

                    @if (count($errors))
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-danger alert-dismissible fade show"> {{ $error }} </p>
                        @endforeach
                    @endif

                    <form action="{{ route('update.password') }}" method="post">
                    @csrf

                        <div class="row mb-3">
                            <label for="oldpassword" class="col-sm-2 col-form-label">Old Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="oldpassword" name="oldpassword">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newpassword" class="col-sm-2 col-form-label">New Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="newpassword" name="newpassword">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                        </div>

                    <input type="submit" class="btn btn-info waves-effect waves-light" value="Change Password">

                    </form>

                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection
