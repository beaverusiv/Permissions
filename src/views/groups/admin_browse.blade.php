@extends('base.backend')

@section('title')
Groups
@stop

@section('content_navigation')
    <div class="row">
        <div class="col-xs-7">
            <h1>Groups</h1>
            <div class="btn-group pull-right">
                <a href="{!! route('groups.adminEdit', [0]) !!}" class="btn btn-primary btn-social">
                    <i class="fa fa-plus-square-o"></i> Add Group
                </a>
            </div>
        </div>
        <div class="col-xs-5">
            <h1>New Group</h1>
            <div class="btn-group pull-right">
                <a href="{!! route('groups.adminSave', [0]) !!}" class="btn btn-primary btn-social">
                    <i class="fa fa-plus-square-o"></i> Save
                </a>
            </div>
        </div>
    </div>
@stop

@section('content')
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- left column -->
        <div class="col-xs-7">
            <div class="box">

                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Users</th>
                                <th>Home Route</th>
                                <th>Created</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                            <tr>
                                <td>{!! $group->id !!}</td>
                                <td>{!! $group->name !!}</td>
                                <td>{!! $group->users()->count() !!}</td>
                                <td>@if($group->home_route) {!! route($group->home_route) !!} @endif</td>
                                <td>{!! $group->created_at !!}</td>
                                <td>
                                    {!! HTML::linkRoute('groups.adminEdit', 'Edit', [$group->id], ['class' => 'btn btn-primary btn-sm']) !!}
                                    {!! HTML::linkRoute('groups.adminDelete', 'Delete', [$group->id], ['class' => 'btn btn-danger btn-sm']) !!}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div><!--/.col -->
        <div class="col-xs-5">
            <div class="box">

                <div class="box-body table-responsive">
                    <!-- text input -->
                    <div class="form-group">
                        <?php // TODO: make this a macro ?>
                        @if(isset($group))
                        {!! Form::model($group, ['route' => ['groups.adminSave', $group->id]]) !!}
                        @else
                        {!! Form::open(['route' => ['groups.adminSave', 0]]) !!}
                        @endif
                        {!! Form::label('name', 'Group Name') !!}
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                        {!! Form::label('home_route', 'Home Route') !!}
                        {!! Form::text('home_route', null, ['class' => 'form-control']) !!}
                        {!! Form::submit('Save Details') !!}
                        {!! Form::close() !!}
                    </div>

                    @if(isset($group))
                    {!! Form::open(['route' => ['groups.adminSave', $group->id]]) !!}
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">Permitted</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($group->permissions()->get() as $permission)
                        <tr>
                            <td class="text-center">{!! $permission->id !!}</td>
                            <td>{!! $permission->route_name !!}</td>
                            <td>{!! Form::text($permission->id.'_name', $permission->name) !!}</td>
                            <td class="text-center">{!! Form::checkbox($permission->id.'_permitted', '1', $permission->permitted) !!}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! Form::submit('Save Permissions') !!}
                    {!! Form::close() !!}
                    @endif

                </div><!-- /.box-body -->

            </div><!-- /.box -->
        </div>
    </div>   <!-- /.row -->
</section><!-- /.content -->
@stop