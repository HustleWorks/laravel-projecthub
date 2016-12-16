@extends('layouts.hub')
@section('content')

    <article>
        @if($method == 'POST')
            <h1 class="entry-title">Create Entry</h1>
        @else
            <h1 class="entry-title">Edit Entry</h1>
        @endif

        @if($method == 'POST')
            {!! Form::open(['url' => '', 'method' => 'post', 'files' => true]) !!}
        @else
            {{Form::model($item, array('route' => array('update', $item->id), 'method' => 'put', 'files' => true))}}
        @endif

                {{Form::hidden('user_id', Auth::user()->id, [])}}

                <!--title-->
                {{Form::label('title', 'Title')}}<br>
                {{ Form::text('title') }}<br>
                @if ($errors->has('title'))
                        <p>{{ $errors->first('title') }}</p>
                @endif

                <!--date-->
                {{Form::label('date', 'Date')}}<br>
                @if($method == 'POST')
                    {{Form::date('date', \Carbon\Carbon::now())}}<br>
                @else
                    {{Form::date('date', $item->date)}}<br>
                @endif
                @if ($errors->has('date'))
                    <p>{{ $errors->first('date') }}</p>
                @endif

                @if($method == 'POST')
                <!--type-->
                {{Form::label('type_name', 'Type')}}<br>
                {{
                    Form::select(
                        'type_name',
                        [
                            'deliverable'   => 'Deliverable',
                            'meeting'       => 'Meeting',
                            'milestone'     => 'Milestone',
                        ],
                        null,
                        [
                            'placeholder'   => 'Pick a type...',
                            'id'            => 'type_select'
                        ]
                    )
                }}
                <br>
                @if ($errors->has('type_name'))
                    <p>{{ $errors->first('type_name') }}</p>
                @endif
                <br>
                @endif

                <!--description-->
                {{Form::label('description', 'Description')}}<br>
                {{ Form::textarea('description') }}<br>

                <!--files-->
                @if($method == 'PUT')
                <br>
                <h3>Files</h3>
                <ul>
                    @foreach($item->hubItemable->files as $f)
                        <li><p><a href="{{$f->getStoragePath().$f->name}}">{{$f->name}}</a> ({{$f->size}}) | <a href="#inline" class="inline" onclick="setDeleteId({{$f->id}})">Delete</a></p></li>
                    @endforeach
                </ul>
                @endif
                {{Form::label('files', 'Upload Files')}}<br>
                {{ Form::file('files[]', ['multiple' => true, 'class' => 'file-input']) }}<br>

                <br>

                <!-- extra form elements for deliverables-->
                <div id="deliverable" class="extra-form-element">

                    <h3>Deliverable</h3>
                    <p>hello deliverable</p>
                </div>

                <!-- extra form elements for meetings-->
                <div id="meeting" class="extra-form-element">
                    <h3>Meeting</h3>
                    @if($method == 'POST')
                        {{Form::label('objectives', 'Objectives')}}<br>
                        {{ Form::textarea('objectives') }}<br>

                        {{Form::label('notes', 'Notes')}}<br>
                        {{ Form::textarea('notes') }}<br>

                        {{Form::label('attendees', 'Attendees')}}<br>
                        {{ Form::textarea('attendees') }}<br>

                        {{Form::label('action_items', 'Action Items')}}<br>
                        {{ Form::textarea('action_items') }}<br>
                    @else
                        {{Form::label('objectives', 'Objectives')}}<br>
                        {{ Form::textarea('objectives', $item->hubItemable->objectives) }}<br>

                        {{Form::label('notes', 'Notes')}}<br>
                        {{ Form::textarea('notes', $item->hubItemable->notes) }}<br>

                        {{Form::label('attendees', 'Attendees')}}<br>
                        {{ Form::textarea('attendees', $item->hubItemable->attendees) }}<br>

                        {{Form::label('action_items', 'Action Items')}}<br>
                        {{ Form::textarea('action_items', $item->hubItemable->action_items) }}<br>
                    @endif
                </div>
                <!-- extra form elements for milestones-->
                <div id="milestone" class="extra-form-element">
                    <h3>Milestone</h3>
                    <p>hello milestone</p>
                </div>

                {{Form::submit('Save')}}


            {{Form::close()}}

    </article><!-- .entry -->

    @if($method == 'PUT')
        <div id="inline" style="display:none;">
            <h2>Delete Item</h2>
            <p>Are you sure you want to delete this file?</p>
            {{ Form::open(['method' => 'delete', 'id' => 'delete-modal-form']) }}
                {{ Form::submit('Delete') }}
                <button type="button" onclick="$('.inline').modaal('close')" id="cancel-modal">Close</button>
            {{ Form::close() }}
        </div>
    @endif

    <script>
        @if($method == 'POST')
        $(document).ready(function() {

            /*
                Detect change of selected form type and show correct extra from elements.
             */
            $('select').change( function () {
                $('.extra-form-element').slideUp();
                var type = $( "#type_select" ).val();
                $('#' + type).slideDown();
            });

        });
        @elseif($method == 'PUT')

        function setDeleteId(id) {
            $('#delete-modal-form').attr('action', '/file/' + id);
        }

        $(document).ready(function() {
            $('.inline').modaal();
            var type = "{{$type}}";
            $('#' + type).show();
        });
        @endif
    </script>
@endsection