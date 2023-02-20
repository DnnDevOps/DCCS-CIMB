@extends('layouts.master')

@section('title', 'Edit Trunk')

@section('content')
	@if (isset($trunk))

<?php
	$customFields = [];

	foreach ($trunk->customFields() as $field => $value) {
		$customFields[] = [
			'Field' => BSForm::text('field[]', $field),
			'Value' => BSForm::text('value[]', $value)
		];
	}

	if (empty($customFields)) {
		$customFields[] = [
			'Field' => BSForm::text('field[]', ''),
			'Value' => BSForm::text('value[]', '')
		];
	}
?>

		{!! Form::open(['method' => 'PUT', 'url' => "/trunk/$trunk->category"]) !!}
			@include('trunk.fields', [
				'trunk' => $trunk->category,
                'defaultuser' => $trunk->defaultuser,
                'host' => $trunk->host,
				'contexts' => $contexts,
				'context' => $trunk->context,
				'customFields' => $customFields
			])
		{!! Form::close() !!}
	@endif
@endsection