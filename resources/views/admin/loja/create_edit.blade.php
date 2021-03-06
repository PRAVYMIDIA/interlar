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
	action="@if(isset($loja)){{ URL::to('admin/loja/'.$loja->id.'/edit') }}
	        @else{{ URL::to('admin/loja/create') }}@endif"
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
							value="{{{ Input::old('nome', isset($loja) ? $loja->nome : null) }}}" />
						{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				
				<div
					class="form-group {{{ $errors->has('descricao') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="descricao">Descrição</label>
						<textarea class="form-control full-width" name="descricao"
							value="descricao" rows="10">{{{ Input::old('descricao', isset($loja) ? $loja->descricao : null) }}}</textarea>
						{!! $errors->first('descricao', '<label class="control-label">:message</label>')
						!!}
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group {{{ $errors->has('localizacao') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="localizacao">Localização</label><input
									class="form-control" type="text" name="localizacao" id="localizacao"
									value="{{{ Input::old('localizacao', isset($loja) ? $loja->localizacao : null) }}}" />
								{!!$errors->first('localizacao', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group {{{ $errors->has('telefone') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="telefone">Telefone</label><input
									class="form-control sp_celphones" type="text" name="telefone" id="telefone"
									value="{{{ Input::old('telefone', isset($loja) ? $loja->telefone : null) }}}" />
								{!!$errors->first('telefone', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group {{{ $errors->has('celular') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="celular">Celular Responsável</label><input
									class="form-control sp_celphones" type="text" name="celular" id="celular"
									value="{{{ Input::old('celular', isset($loja) ? $loja->celular : null) }}}" />
								{!!$errors->first('celular', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
				</div>

				<div class="form-group {{{ $errors->has('loja_tipo_id') ? 'error' : '' }}}">
					<div class="col-lg-12">
						<label class="control-label" for="loja_tipo_id">Tipo da Loja - Segmento</label>
						{!! Form::select('loja_tipo_id',$lojastipos, (isset($loja) ? $loja->loja_tipo_id : null),array('class'=>'form-control','required'=>'required') );  !!}
					</div>
				</div>
				@if((isset($loja) ? $loja->imagem : '')!='' )
				<div class="form-group">
					<img class="img-responsive img-thumbnail" title="imagem atual" src="/images/loja/{{$loja->id.'/'.$loja->imagem}}" alt="Imagem atual">
				</div>
				@endif
				<div
					class="form-group {{{ $errors->has('imagem') ? 'error' : '' }}}">
					<div class="col-lg-12">
						<label class="control-label" for="imagem">{{ (isset($loja) ? $loja->imagem : '')!=''?'Trocar ':'Inserir ' }}Imagem</label> 
						<input name="imagem" type="file" class="uploader" id="imagem" value="Upload" />
						<div class="help-text">Largura x Altura : <strong>205px x 140px</strong></div>
					</div>

				</div>
				<div
					class="form-group {{{ $errors->has('ativo') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="ativo">{{
						trans('admin/users.activate_user') }}</label>						
						<select class="form-control" name="ativo" id="ativo">
							<option value="1" {{{ ((isset($loja) && $loja->ativo == 1)? '
								selected="selected"' : '') }}}>SIM</option>
							<option value="0" {{{ ((isset($loja) && $loja->ativo == 0) ?
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
						@if	(isset($loja)) 
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
