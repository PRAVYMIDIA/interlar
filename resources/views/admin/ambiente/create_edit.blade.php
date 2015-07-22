@extends('admin.layouts.modal')

@section('styles')
<link href="{{{ asset('assets/admin/css/bootstrap-duallistbox.css') }}}"
	rel="stylesheet" type="text/css">
@stop

{{-- Content --}} 
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab"> Ambiente</a></li>
	<li><a href="#tab-produtos" data-toggle="tab"> Produtos neste Ambiente</a></li>
</ul>
<!-- ./ tabs -->
{{-- Edit Ambiente Form --}}
<form class="form-horizontal" id="fupload" enctype="multipart/form-data"
	method="post"
	action="@if(isset($ambiente)){{ URL::to('admin/ambiente/'.$ambiente->id.'/edit') }}
	        @else{{ URL::to('admin/ambiente/create') }}@endif"
	autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	@if(isset($ambiente))
	<input type="hidden" name="id" value="{{{ $ambiente->id }}}" />
	@endif
	<!-- ./ csrf token -->
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		
			<div class="tab-pane active" id="tab-general">
				
				<div
					class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="nome"> Nome</label> <input
							class="form-control" type="text" name="nome" id="nome" maxlength="255"
							value="{{{ Input::old('nome', isset($ambiente) ? $ambiente->nome : null) }}}" />
						{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				
				<div
					class="form-group {{{ $errors->has('descricao') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="descricao">Descrição</label>
						<input  maxlength="255" class="form-control" type="text" name="descricao"
							value="{{{ Input::old('descricao', isset($ambiente) ? $ambiente->descricao : null) }}}" />
						{!! $errors->first('descricao', '<label class="control-label">:message</label>')
						!!}
					</div>
				</div>
				@if((isset($ambiente) ? $ambiente->imagem : '')!='' )
				<div class="form-group center-block">
					<a href="/images/ambiente/{{$ambiente->id.'/'.$ambiente->imagem }}" target="_blank"><img class="img-responsive img-thumbnail center-block" title="imagem atual" src="/images/ambiente/{{$ambiente->id.'/'.$ambiente->thumb()}}" alt="Imagem atual"></a>
				</div>
				@endif
				<div
					class="form-group {{{ $errors->has('imagem') ? 'error' : '' }}}">
					<div class="col-lg-12">
						<label class="control-label" for="imagem">{{ (isset($ambiente) ? $ambiente->imagem : '')!=''?'Trocar ':'Inserir ' }}Imagem</label> <input name="imagem"
							type="file" class="uploader" id="imagem" value="Upload" />
					</div>

				</div>
				<!-- ./ general tab -->
			</div>
			<!-- ./ tabs content -->

			<!-- Produtos tab -->
			<div class="tab-pane" id="tab-produtos">
				<br>
				<select class="form-control" multiple="multiple" size="10" name="produto_ambiente[]">
				@foreach($produtos as $id => $produto)
			      <option value="{{$id}}"
			      @if(isset($produtos_ambientes))
			      	@if(isset($produtos_ambientes[$id]))
			      		selected="selected"
			      	@endif
			      @endif
			      >{{$produto}}</option>
			    @endforeach
			    </select>
			</div>
			<!-- ./ Produtos tab -->

			<!-- Form Actions -->

			<div class="form-group" style="margin-top:20px;">
				<div class="col-md-12">
					<button type="reset" class="btn btn-sm btn-warning close_popup">
						<span class="glyphicon glyphicon-ban-circle"></span> {{
						trans("admin/modal.cancel") }}
					</button>
					
					<button type="submit" class="btn btn-sm btn-success">
						<span class="glyphicon glyphicon-ok-circle"></span> 
						@if	(isset($ambiente)) 
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

@section('scripts')
	@parent
	<script src="{{  asset('assets/admin/js/jquery.bootstrap-duallistbox.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function($) {
			var bootstrapduallist = $('select[name="produto_ambiente[]"]').bootstrapDualListbox({
				 nonSelectedListLabel: 'Produtos Disponíveis',
  				selectedListLabel: 'Produtos Selecionados',
			});
		});
	</script>

@stop
