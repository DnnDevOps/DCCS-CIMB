@extends('layouts.master')

@section('styles')
    @parent

	{!! Html::style('css/bootstrap-toggle.css') !!}
@endsection

@section('scripts')
	@parent
	
	{!! Html::script('js/bootstrap-toggle.js') !!}
	{!! Html::script('js/permission.js') !!}
@endsection

@section('title', 'Daftar Admin')

@section('content')
    <table class="table table-condensed">
        <thead>
            <tr>
                <th>Hak Akses</th>
                @foreach ($roles as $role)
                    <th>{{ $role->role }}</th>
                @endforeach
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr>
                    <td>{{ $permission->title }}</td>
                    @foreach ($roles as $role)
                        <td>
                            <input type="checkbox" {{ in_array($permission->id, $role->permissions()) ? 'checked' : '' }}
                                data-role-id="{{ $role->id }}"
                                data-permission-id="{{ $permission->id }}"
                                data-toggle="toggle"
                                data-size="mini"
                                data-on="Boleh"
                                data-off="Tidak"
                                data-onstyle="success">
                        </td>
                    @endforeach
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection