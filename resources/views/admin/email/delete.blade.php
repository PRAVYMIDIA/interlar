@extends('admin.layouts.modal') {{-- Content --}} @section('content')

{{-- Delete Post Form --}}
<form id="deleteForm" class="form-horizontal" method="post"
	action="@if (isset($email)){{ URL::to('admin/email/' . $email->id . '/delete') }}@endif"
	autocomplete="off">

	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> 
	<input type="hidden" name="id" value="{{ $email->id }}" />
	<!-- <input type="hidden" name="_method" value="DELETE" /> -->
	<!-- ./ csrf token -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="controls">
			{{ trans("admin/modal.delete_message") }}<br>

			<br>
			<h2>{{ $email->email }}</h2>
			<br>
			<element class="btn btn-warning btn-sm close_popup">
			<span class="glyphicon glyphicon-ban-circle"></span> {{
			trans("admin/modal.cancel") }}</element>
			<button type="submit" class="btn btn-sm btn-danger">
				<span class="glyphicon glyphicon-trash"></span> {{
				trans("admin/modal.delete") }}
			</button>
		</div>
	</div>
	<!-- ./ form actions -->
</form>
@stop
