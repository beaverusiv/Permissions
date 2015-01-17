@extends('base.backend')

@section('title')
Browse Groups
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">

            <div class="box-header">
                <h3 class="box-title">Groups</h3>
                <div class="box-tools">
                    <div class="input-group">
                        <input name="table_search" class="form-control input-sm pull-right" style="width: 150px;" placeholder="Search" type="text">
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-header -->

            <div class="box-body table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Users</th>
                            <th>Created</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $group)
                        <tr>
                            <td>{{ $group->id }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->users()->count() }}</td>
                            <td>{{ $group->created_at }}</td>
                            <td>
                                {{ HTML::linkRoute('groups.adminEdit', '[edit]', array($group->id)) }}
                                {{ HTML::linkRoute('groups.adminDelete', '[delete]', array($group->id)) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><!-- /.box-body -->

        </div><!-- /.box -->
    </div>
</div>
@stop