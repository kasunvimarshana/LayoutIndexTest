@extends('layouts.app_layout')

@section('styles')
    @parent
@endsection
@section('scripts')
    @parent
@endsection

@push('page_scripts')

<script>
    $(function(){

        $("#myform").validate({
            onfocusout: false,
            onkeyup: false,
            rules: {
                name: 'required',
                password: {
                    required: false,
                },
                confirm_password: {
                    required: false,
                    equalTo: '#password'
                },
                email: {
                    required: true,
                    email: true
                },
                role_id: {
                    required: true
                }
            },
            messages: {
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                confirm_password: {
                    required: "Please provide a password",
                    equalTo: "Please enter the same password as above"
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address."
                },
                role_id: {
                    required: "Please provide a Role."
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });

    });
</script>

@endpush

@section('container')
    <!-- -->
    <div class="page-header">
        <h1 class="display-4">Edit User</h1>
    </div>

    <div class="row">
        <div class="col col-md-8">

            <form id="myform" action="{{ route('user.update', ['id' => $user->id]) }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" autocomplete="off" value="{{ $user->name }}"/>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off" value="{{ $user->email }}"/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="role_id">Role</label>
                    <select name="role_id" id="role_id" class="form-control" autocomplete="off"/>
                    @isset( $roles )
                        @foreach($roles as $key => $value)
                            @php
                                $id = $value->id;
                                $name = $value->name;
                                $is_selected = ($value->id == $user->role_id) ? "selected" : null;
                            @endphp
                            <option value="{{$id}}" {{$is_selected}}>{{$name}}</option>
                        @endforeach
                    @endisset
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
    <!-- -->
@endsection