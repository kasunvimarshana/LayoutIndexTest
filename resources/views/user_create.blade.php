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

        jQuery.validator.addMethod('email_rule', function(value, element) {
            var isSuccess = false;

            $.ajax({ 
                url: "{!! route('user.checkValidUser', []) !!}", 
                type: "POST",
                data: {
                    '_token': function(){
                        return $("input[name='_token']").val();
                    },
                    'email': function(){
                        return value;
                    },
                    'match_case': function(){
                        return false;
                    }
                }, 
                async: false, 
                success: function(data) { 
                    //console.log( data );
                    isSuccess = (data.isValidUser == false ? true : false);
                }
            });

            return isSuccess;
        }, function(value, element){
            var element_value = $( element ).val();
            return ( element_value + " is already taken" );
        });


        $("#myform").validate({
            onfocusout: false,
            onkeyup: false,
            rules: {
                name: 'required',
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    equalTo: '#password'
                },
                email: {
                    required: true,
                    email: true,
                    email_rule: true
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
        <h1 class="display-4">Create User</h1>
    </div>

    <div class="row">
        <div class="col col-md-8">

            <form id="myform" action="{{ route('user.store', []) }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" autocomplete="off"/>
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
                            @endphp
                            <option value="{{$id}}">{{$name}}</option>
                        @endforeach
                    @endisset
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>

    <!-- --- -->
    <div class="row">
        <div class="col col-md-12">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                        
                    <tbody>
                        @isset( $users )
                            @foreach($users as $key => $value)
                                @php
                                    $id = $value->id;
                                    $name = $value->name;
                                    $email = $value->email;
                                    $role = $value->role->name;
                                @endphp
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td>{{ $email }}</td>
                                    <td>{{ $role }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('user.edit', ['id' => $id])}}" role="button">Edit</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="{{route('user.destroy', ['id' => $id])}}" role="button" onclick="return confirm('Continue?')">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- --- -->
    <!-- -->
@endsection