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
                title: 'required',
                description: {
                    required: false
                },
                tag_id: {
                    required: false
                }
            },
            messages: {
                title: {
                    required: "Please provide a Title"
                },
                description: {
                    required: "Please provide a Description"
                },
                tag_id: {
                    required: "Please provide the Tags"
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
        <h1 class="display-4">Create Post</h1>
    </div>

    <div class="row">
        <div class="col col-md-8">

            <form id="myform" action="{{ route('post.store', []) }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" autocomplete="off"/>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Description" autocomplete="off" rows="5"/></textarea>
                </div>
                <div class="form-group">
                    <label for="tag_id">Tags ( Seperate Tags using "," )</label>
                    <textarea name="tag_id" id="tag_id" class="form-control" placeholder="Tag1,Tag2,Tag3" autocomplete="off" rows="5"/></textarea>
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
                            <th>User</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Tags</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                        
                    <tbody>
                        @isset( $posts )
                            @foreach($posts as $key => $value)
                                @php
                                    $id = $value->id;
                                    $user_id = $value->user_id;
                                    $title = $value->title;
                                    $description = $value->description;
                                    $time_create = $value->time_create;
                                    $tags = $value->tags;
                                    $user_name = $value->user->name;
                                    /*$tags = $value->tags->map(function ($tag) {
                                        return collect($tag)->only(['name']);
                                    });*/
                                    $tags = $tags->implode('name', ' , ');
                                @endphp
                                <tr>
                                    <td>{{ $user_name }}</td>
                                    <td>{{ $title }}</td>
                                    <td>{{ $description }}</td>
                                    <td>{{ $tags }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('post.edit', ['id' => $id])}}" role="button">Edit</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-danger" href="{{route('post.destroy', ['id' => $id])}}" role="button" onclick="return confirm('Continue?')">Delete</a>
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