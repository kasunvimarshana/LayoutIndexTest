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
        //
    });
</script>

@endpush

@section('container')
    <!-- -->
    <div class="row">
        <div class="jumbotron">
            <!-- --- -->
            <div class="row">
                <div class="col col-md-8">

                    <form id="myform" action="{{ route('home', []) }}" method="GET" autocomplete="off">
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
        </div>
    </div>

    <!-- --- -->
    <div class="row">
        <div class="col">
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
            
                    <div class="col col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">{{ $title }}</div>
                            <div class="panel-body">
                                <p>{{ $description }}</p>
                                <p>{{ $tags }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endisset
        </div>
    </div>
    <!-- --- -->
    <!-- -->
@endsection