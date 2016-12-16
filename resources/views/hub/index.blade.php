@extends('layouts.hub')
@section('content')

            @if($items->count() < 1)
                <h2>There are no items to list yet.</h2>
            @endif

            @foreach($items as $item)
            <article class="entry @if($item->date > \Carbon\Carbon::now()) entry-future @elseif($item->id == $latest) entry-latest @endif">
                <h1 class="entry-title">{{$item->title}}</h1>
                <p class="entry-date">{{$item->date}}</p>
                @if(Auth::user())
                <p><a href="/{{$item->id}}/edit">Edit</a> | <a href="#inline" class="inline" onclick="setDeleteId({{$item->id}})">Delete</a></p>
                @endif
                <p></p>

                <h3>Details</h3>
                <p>{{$item->description}}</p>

                @if($item->hubItemable)
                    @if($item->hub_itemable_type == 'App\Models\Meeting')

                        <h3>Objectives</h3>
                        <p>{{$item->hubItemable->objectives}}</p>

                        <h3>Notes</h3>
                        <p>{{$item->hubItemable->notes}}</p>

                        <h3>Attendees</h3>
                        <p>{{$item->hubItemable->attendees}}</p>

                        <h3>Action Items</h3>
                        <p>{{$item->hubItemable->action_items}}</p>

                    @endif
                @endif

                @if($item->hubItemable->files->count() > 0)
                    <h3>Associated Files</h3>
                    <ul>
                    @foreach($item->hubItemable->files as $f)
                        <li><p><a href="{{$f->getStoragePath().$f->name}}">{{$f->name}}</a> ({{$f->size}})</p></li>
                    @endforeach
                    </ul>
                @endif

            </article>
            @endforeach



            <div id="inline" style="display:none;">
                <h2>Delete Item</h2>
                <p>Are you sure you want to delete this item?</p>
                {{ Form::open(['method' => 'delete', 'id' => 'delete-modal-form']) }}
                    {{ Form::submit('Delete') }}
                    <button type="button" onclick="$('.inline').modaal('close')" id="cancel-modal">Close</button>
                {{ Form::close() }}
            </div>

            <script>

                function setDeleteId(id) {
                    $('#delete-modal-form').attr('action', id);
                }

                $(document).ready(function () {
                    $('.inline').modaal();
                });
            </script>

@endsection