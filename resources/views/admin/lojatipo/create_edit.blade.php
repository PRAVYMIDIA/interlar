@extends('admin.layouts.modal') {{-- Content --}} @section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab"> {{
			trans("admin/modal.general") }}</a></li>
</ul>
<!-- ./ tabs -->
{{-- Edit Loja Form --}}
<form class="form-horizontal" id="fupload" enctype="multipart/form-data"
	method="post"
	action="@if(isset($lojatipo)){{ URL::to('admin/lojatipo/'.$lojatipo->id.'/edit') }}
	        @else{{ URL::to('admin/lojatipo/create') }}@endif"
	autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	@if(isset($lojatipo))
	<input type="hidden" name="id" value="{{{ $lojatipo->id }}}" />
	@endif
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
							class="form-control" type="text" name="nome" id="nome" maxlength="255"
							value="{{{ Input::old('nome', isset($lojatipo) ? $lojatipo->nome : null) }}}" />
						{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				
				<div
					class="form-group {{{ $errors->has('descricao') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="descricao">Descrição</label>
						<textarea class="form-control full-width" name="descricao"
							value="descricao" rows="10">{{{ Input::old('descricao', isset($lojatipo) ? $lojatipo->descricao : null) }}}</textarea>
						{!! $errors->first('descricao', '<label class="control-label">:message</label>')
						!!}
					</div>
				</div>

				<div
					class="form-group {{{ $errors->has('ativo') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="ativo">{{
						trans('admin/users.activate_user') }}</label>						
						<select class="form-control" name="ativo" id="ativo">
							<option value="1" {{{ ((isset($lojatipo) && $lojatipo->ativo == 1)? '
								selected="selected"' : '') }}}>SIM</option>
							<option value="0" {{{ ((isset($lojatipo) && $lojatipo->ativo == 0) ?
								' selected="selected"' : '') }}}>NÃO</option>
						</select>
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
						@if	(isset($lojatipo)) 
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
