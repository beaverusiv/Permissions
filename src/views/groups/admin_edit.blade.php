@extends('base.backend')

@section('title')
Edit Group
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">Edit Group</h3>
            </div><!-- /.box-header -->

            <div class="box-body table-responsive">
                <!-- text input -->
                <div class="form-group">
                    <?php // TODO: make this a macro ?>
                    @if(isset($group))
                    {{ Form::model($group, ['route' => ['groups.adminSave', $group->id]]) }}
                    @else
                    {{ Form::open(['route' => ['groups.adminSave', 0]]) }}
                    @endif
                    {{ Form::label('name', 'Group Name') }}
                    {{ Form::text('name', null, ['class' => 'form-control']) }}
                    {{ Form::label('home_route', 'Home Route') }}
                    {{ Form::text('home_route', null, ['class' => 'form-control']) }}
                    {{ Form::submit('Save Details') }}
                    {{ Form::close() }}
                </div>

                @if(isset($group))
                {{ Form::open(['route' => ['groups.adminSave', $group->id]]) }}
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Permitted</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($group->permissions()->get() as $permission)
                    <tr>
                        <td>{{ $permission->id }}</td>
                        <td>{{ $permission->route_name }}</td>
                        <td>{{ Form::text($permission->id.'_name', $permission->name) }}</td>
                        <td>{{ Form::checkbox($permission->id.'_permitted', '1', $permission->permitted) }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ Form::submit('Save Permissions') }}
                {{ Form::close() }}
                @endif

            </div><!-- /.box-body -->

        </div><!-- /.box -->
    </div>
</div>
@stop