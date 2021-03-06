@extends('admin.layouts.modal') {{-- Content --}} @section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab"> {{
			trans("admin/modal.general") }}</a></li>
</ul>
<!-- ./ tabs -->
{{-- Edit Fornecedor Form --}}
<form class="form-horizontal" id="fupload" enctype="multipart/form-data"
	method="post"
	action="@if(isset($fornecedor)){{ URL::to('admin/fornecedor/'.$fornecedor->id.'/edit') }}
	        @else{{ URL::to('admin/fornecedor/create') }}@endif"
	autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		<div class="tab-pane active" id="tab-general">
			<div class="tab-pane active" id="tab-general">
				
				<div
					class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="nome"> Nome</label> <input
							class="form-control" type="text" name="nome" id="nome"
							value="{{{ Input::old('nome', isset($fornecedor) ? $fornecedor->nome : null) }}}" />
						{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				
				<div
					class="form-group {{{ $errors->has('descricao') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="descricao">Descrição</label>
						<input type="text" maxlength="255" class="form-control" name="descricao" value="{{ Input::old('descricao', isset($fornecedor) ? $fornecedor->descricao : null) }}" />
						{!! $errors->first('descricao', '<label class="control-label">:message</label>')
						!!}
					</div>
				</div>
				
				<!-- ./ general tab -->
			</div>
			<!-- ./ tabs content -->

			<!-- Form Actions -->

			<div class="form-group">
				<div class="col-md-12">
					<button type="reset" class="btn btn-sm btn-warning close_popup">
						<span class="glyphicon glyphicon-ban-circle"></span> {{
						trans("admin/modal.cancel") }}
					</button>
					<button type="submit" class="btn btn-sm btn-success">
						<span class="glyphicon glyphicon-ok-circle"></span> 
						@if	(isset($fornecedor)) 
						  {{ trans("admin/modal.edit") }}
						@else 
						  {{trans("admin/modal.create") }}
						@endif
					</button>
				</div>
			</div>
			<!-- ./ form actions -->

</form>
@stop
