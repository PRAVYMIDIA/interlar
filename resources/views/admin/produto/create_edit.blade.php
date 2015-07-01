@extends('admin.layouts.modal') {{-- Content --}} @section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">Produto</a></li>
	<li><a href="#tab-imagens" data-toggle="tab">Imagens Extras</a></li>
</ul>
<!-- ./ tabs -->
{{-- Edit Produto Form --}}
<form class="form-horizontal" id="fupload" enctype="multipart/form-data"
	method="post"
	action="@if(isset($produto)){{ URL::to('admin/produto/'.$produto->id.'/edit') }}
	        @else{{ URL::to('admin/produto/create') }}@endif"
	autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- Produto tab -->
		<div class="tab-pane active" id="tab-general">
				
			<div class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="nome"> Nome</label> <input
						class="form-control" type="text" name="nome" id="nome"
						value="{{{ Input::old('nome', isset($produto) ? $produto->nome : null) }}}" />
					{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
				</div>
			</div>
			@if((isset($produto) ? $produto->imagem : '')!='' )
			<div class="form-group">
				<img class="img-responsive img-thumbnail" title="imagem atual" src="/images/produto/{{$produto->id.'/'.$produto->imagem}}" alt="Imagem atual">
			</div>
			@endif
			<div
				class="form-group {{{ $errors->has('imagem') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label" for="imagem">{{ (isset($produto) ? $produto->imagem : '')!=''?'Trocar ':'Inserir ' }}Imagem Principal</label> <input name="imagem"
						type="file" class="uploader" id="imagem" value="Upload" />
				</div>

			</div>
			<div class="form-group {{{ $errors->has('produto_tipo_id') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label" for="produto_tipo_id">Tipo</label>
					{!! Form::select('produto_tipo_id',$produtos_tipos, (isset($produto) ? $produto->produto_tipo_id : null),array('class'=>'form-control','required'=>'required') );  !!}
				</div>
			</div>

			<div class="form-group {{{ $errors->has('produto_tipo_id') ? 'error' : '' }}}">
				<div class="col-lg-12">
					<label class="control-label" for="fornecedor_id">Fornecedor</label>
					{!!  Form::select('fornecedor_id',array_merge(array(''=>'Não informado'),$fornecedores), (isset($produto) ? $produto->fornecedor_id : null),array('class'=>'form-control') );  !!}
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group {{{ $errors->has('valor') ? 'has-error' : '' }}}">
						<div class="col-md-12">
							<label class="control-label" for="valor"> Valor</label> 
							<input
								class="form-control moeda" type="text" name="valor" id="valor"
								value="{{{ Input::old('valor', isset($produto) ? $produto->valor : null) }}}" />
							{!!$errors->first('valor', '<label class="control-label">:message</label>')!!}
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group {{{ $errors->has('parcelas') ? 'has-error' : '' }}}">
						<div class="col-md-12">
							<label class="control-label" for="parcelas"> Parcelas</label> 
							<input
								class="form-control" type="text" name="parcelas" id="parcelas"
								value="{{{ Input::old('parcelas', isset($produto) ? $produto->parcelas : null) }}}" />
							{!!$errors->first('parcelas', '<label class="control-label">:message</label>')!!}
						</div>
					</div>
				</div>
			</div>

			<div class="form-group {{{ $errors->has('descricao') ? 'has-error' : '' }}}">
				<div class="col-md-12">
					<label class="control-label" for="descricao">Descrição</label>
					<textarea class="form-control full-width wysihtml5" name="descricao"
						value="descricao" rows="4">{{{ Input::old('descricao', isset($produto) ? $produto->descricao : null) }}}</textarea>
					{!! $errors->first('descricao', '<label class="control-label">:message</label>')
					!!}
				</div>
			</div>
		</div>
		<!-- ./ Produto tab -->
		<!-- Imagens extras tab -->
		<div class="tab-pane" id="tab-imagens">
			<br>
			@if(isset($produto))
				@if( count( $produto->imagens ) )
					@foreach($produto->imagens as $imagem)
						<div class="row">
							<div class="col-md-10">
								<img class="img-responsive img-thumbnail" title="imagem extra {{ $imagem->id }}" src="/images/produto/{{$produto->id.'/'.$imagem->imagem }}" alt="Imagem">
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-danger" onclick="remover({{ $imagem->id }});"> <i class="fa fa-times"></i> Remover </button>
							</div>
						</div>
					@endforeach
				@endif
			@endif
			<button class="btn btn-success" type="button" onclick="adicionar();"><i class="fa fa-plus"></i> Adicionar mais uma imagem</button>
			<div class="form-group" id="produtos_imagens">
				<div class="col-lg-12">
					<label class="control-label" for="imagem">Imagem Extra</label> 
					<input name="produto_imagem[]" type="file" class="uploader" value="" />
				</div>

			</div>
		</div>
		<!-- ./ Imagens extras tab -->

			<!-- ./ tabs content -->

			<!-- Form Actions -->

			<div class="form-group">
				<div class="col-md-12">
					<button type="reset" class="btn btn-sm btn-warning close_popup">
						<span class="glyphicon glyphicon-ban-circle"></span> {{
						trans("admin/modal.cancel") }}
					</button>
					<button type="reset" class="btn btn-sm btn-default">
						<span class="glyphicon glyphicon-remove-circle"></span> {{
						trans("admin/modal.reset") }}
					</button>
					<button type="submit" class="btn btn-sm btn-success">
						<span class="glyphicon glyphicon-ok-circle"></span> 
						@if	(isset($produto)) 
						  {{ trans("admin/modal.edit") }}
						@else 
						  {{trans("admin/modal.create") }}
						@endif
					</button>
				</div>
			</div>
	</div>
			<!-- ./ form actions -->

</form>
@stop

@section('scripts')
	@parent
	<script type="text/javascript">
		function remover (imagem_id) {
			// @TODO REMOVER por ajax
			console.log(imagem_id);
		}
		function adicionar () {
			// @TODO Adicionar
			console.log('Adicionar');
		}
	</script>
@stop
