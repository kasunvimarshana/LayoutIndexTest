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
        <h1 class="display-4">Edit Post</h1>
    </div>

    <div class="row">
        <div class="col col-md-8">

            <form id="myform" action="{{ route('post.update', ['id' => $post->id]) }}" method="POST" autocomplete="off">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" autocomplete="off" value="{{ $post->title }}"/>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" placeholder="Description" autocomplete="off" rows="5"/>{{$post->description}}</textarea>
                </div>
                <div class="form-group">
                    @php
                        $tags = $post->tags;
                        /*$tags = $post->tags->map(function ($tag) {
                            return collect($tag)->only(['name']);
                        });*/
                        $tags = $tags->implode('name', ' , ');
                    @endphp
                    <label for="tag_id">Tags ( Seperate Tags using "," )</label>
                    <textarea name="tag_id" id="tag_id" class="form-control" placeholder="Tag1,Tag2,Tag3" autocomplete="off" rows="5"/>{{$tags}}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>

        </div>
    </div>
    <!-- -->
@endsection