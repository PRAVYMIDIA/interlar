@extends('admin.layouts.modal') 

@section('styles')
<link href="{{{ asset('assets/admin/css/bootstrap-duallistbox.css') }}}"
	rel="stylesheet" type="text/css">
@stop

{{-- Content --}} 
@section('content')
<style type="text/css">
#produtos_imagens{
	margin-top: 15px;
}
</style>
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">Produto</a></li>
	<li><a href="#tab-imagens" data-toggle="tab">Imagens Extras</a></li>
	<li><a href="#tab-ambientes" data-toggle="tab">Ambientes</a></li>
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
			<div class="form-group center-block">
				<a href="/images/produto/{{$produto->id.'/'.$produto->imagem }}" target="_blank"><img class="img-responsive img-thumbnail center-block" title="imagem atual" src="/images/produto/{{$produto->id.'/'.$produto->thumb()}}" alt="Imagem atual"></a>
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
			<ul class="list-group">
				@if( count( $produto->imagens ) )
					@foreach($produto->imagens as $imagem)
						<li class="list-group-item" id="imagem_extra_{{ $imagem->id }}">
								<a href="/images/produto/{{$produto->id.'/'.$imagem->imagem }}" target="_blank" title="Ver imagem em tamanho máximo">
								<img class="img-responsive img-thumbnail" title="imagem extra {{ $imagem->id }}" src="/images/produto/{{$produto->id.'/'.$imagem->thumb() }}" alt="Imagem">
								</a>
								<button type="button" class="btn btn-danger" onclick="remover({{ $imagem->id }});"> <i class="fa fa-times"></i> Remover </button>
							
						</li>
					@endforeach
				@endif
			</ul>
			@endif
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<button class="btn btn-success btn-block" type="button" onclick="adicionar();"><i class="fa fa-plus"></i> Adicionar mais uma imagem</button>
				</div>
			</div>
			<div id="produtos_imagens">
				<div class="well well-sm">
					<span class="pull-right">
						<button type="button" class="btn btn-xs btn-danger" onclick="removeUpload(this);" title="Remover"><i class="fa fa-times"></i></button>
					</span>
					<label class="control-label" for="imagem">Imagem Extra</label> 
					<input name="produto_imagem[]" type="file" class="uploader" value="" />
				</div>

			</div>
		</div>
		<!-- ./ Imagens extras tab -->

		<!-- Ambientes tab -->
		<div class="tab-pane" id="tab-ambientes">
			<br>
			<select class="form-control" multiple="multiple" size="10" name="produto_ambiente[]">
			@foreach($ambientes as $id => $ambiente)
		      <option value="{{$id}}"
		      @if(isset($produtos_ambientes))
		      	@if(isset($produtos_ambientes[$id]))
		      		selected="selected"
		      	@endif
		      @endif
		      >{{$ambiente}}</option>
		    @endforeach
		    </select>
		</div>
		<!-- ./ Ambientes tab -->

			<!-- ./ tabs content -->

			<!-- Form Actions -->

			<div class="form-group" style="margin-top:20px;">
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
	<script src="{{  asset('assets/admin/js/jquery.bootstrap-duallistbox.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function($) {
			var bootstrapduallist = $('select[name="produto_ambiente[]"]').bootstrapDualListbox({
				 nonSelectedListLabel: 'Ambientes Disponíveis',
  				selectedListLabel: 'Ambientes Selecionados',
			});
		});
		function remover (imagem_id) {
			var remove = confirm('Remover esta imagem?');
			if(remove){
				$.ajax({
					url: '{{ URL::to('admin/produto/removerimagem') }}/'+imagem_id,
				})
				.done(function() {
					$('#imagem_extra_'+imagem_id).hide('fast', function() {
						$(this).remove();
					});
				})
				.fail(function() {
					alert('Erro ao remover imagem.');
				});
			}
			
			
		}
		function adicionar () {
			$('#produtos_imagens').append('<div class="well well-sm">\
					<span class="pull-right">\
						<button type="button" class="btn btn-xs btn-danger" onclick="removeUpload(this);" title="Remover"><i class="fa fa-times"></i></button>\
					</span>\
					<label class="control-label" for="imagem">Imagem Extra</label> \
					<input name="produto_imagem[]" type="file" class="uploader" value="" />\
				</div>');
		}
		function removeUpload(qual){
			$(qual).closest('div').remove();
		}
	</script>
@stop
