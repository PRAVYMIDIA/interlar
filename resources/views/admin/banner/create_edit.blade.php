@extends('admin.layouts.modal')

@section('styles')
<link href="{{{ asset('assets/admin/css/bootstrap-duallistbox.css') }}}"
	rel="stylesheet" type="text/css">
@stop

{{-- Content --}} 
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab"> Banner</a></li>
	@if(isset($banner))
	<li><a href="#tab-visitas" data-toggle="tab"> Visitas</a></li>
	@endif
</ul>
<!-- ./ tabs -->
{{-- Edit Banner Form --}}
<form class="form-horizontal" id="fupload" enctype="multipart/form-data"
	method="post"
	action="@if(isset($banner)){{ URL::to('admin/banner/'.$banner->id.'/edit') }}
	        @else{{ URL::to('admin/banner/create') }}@endif"
	autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	<!-- ./ csrf token -->
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		
			<div class="tab-pane active" id="tab-general">
				
				<div
					class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="nome"> Nome</label> <input
							class="form-control" type="text" name="nome" id="nome"  required="required
							value="{{{ Input::old('nome', isset($banner) ? $banner->nome : null) }}}" />
						{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				<div
					class="form-group {{{ $errors->has('url') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="url"> URL (Link de destino)</label> <input
							class="form-control" type="url" name="url" id="url" required="required"
							value="{{{ Input::old('url', isset($banner) ? $banner->url : null) }}}" />
						{!!$errors->first('url', '<label class="control-label">:message</label>')!!}
					</div>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group {{{ $errors->has('dtinicio') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="dtinicio"> Início da Exibição</label> 
								<input
									class="form-control date" type="text" name="dtinicio" id="dtinicio" required="required"
									value="{{{ Input::old('dtinicio', isset($banner) ? $banner->dtinicio : null) }}}" />
								{!!$errors->first('dtinicio', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group {{{ $errors->has('dtfim') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="dtfim"> Fim da Exibição</label> 
								<input
									class="form-control date" type="text" name="dtfim" id="dtfim" required="required"
									value="{{{ Input::old('dtfim', isset($banner) ? $banner->dtfim : null) }}}" />
								{!!$errors->first('dtfim', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
				</div>
				
				<div
					class="form-group {{{ $errors->has('html') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="html">HTML</label>
						<textarea class="form-control full-width wysihtml5" name="html"
							value="html" rows="10">{{{ Input::old('html', isset($banner) ? $banner->html : null) }}}</textarea>
						{!! $errors->first('html', '<label class="control-label">:message</label>')
						!!}
					</div>
				</div>
				@if((isset($banner) ? $banner->imagem : '')!='' )
				<div class="form-group center-block">
					<a href="/images/banner/{{$banner->id.'/'.$banner->imagem }}" target="_blank"><img class="img-responsive img-thumbnail center-block" title="imagem atual" src="/images/banner/{{$banner->id.'/'.$banner->thumb()}}" alt="Imagem atual"></a>
				</div>
				@endif
				<div
					class="form-group {{{ $errors->has('imagem') ? 'error' : '' }}}">
					<div class="col-lg-12">
						<label class="control-label" for="imagem">{{ (isset($banner) ? $banner->imagem : '')!=''?'Trocar ':'Inserir ' }}Imagem</label> <input name="imagem"
							type="file" class="uploader" id="imagem" value="Upload" />
					</div>

				</div>
				<!-- ./ general tab -->
			</div>
			<!-- ./ tabs content -->
			
			@if(isset($banner))
			<!-- Visitas tab -->
			<div class="tab-pane" id="tab-visitas">
				<br>
				<table class="table table-striped">
			      <thead>
			        <tr>
			          <th>Dia x Mês</th>
			          <th>Jan</th>
			          <th>Fev</th>
			          <th>Mar</th>
			          <th>Abr</th>
			          <th>Mai</th>
			          <th>Jun</th>
			          <th>Jul</th>
			          <th>Ago</th>
			          <th>Set</th>
			          <th>Out</th>
			          <th>Nov</th>
			          <th>Dez</th>
			        </tr>
			      </thead>
			      <tbody>
			      	@for($i=1;$i<=31;$i++)
			        <tr>
			          <th scope="row">{{$i}}</th>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			          <td>-</td>
			        </tr>
			        @endfor
			      </tbody>
			    </table>
			</div>
			<!-- ./ Visitas tab -->
			@endif
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
						@if	(isset($banner)) 
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
			var bootstrapduallist = $('select[name="produto_banner[]"]').bootstrapDualListbox({
				 nonSelectedListLabel: 'Produtos Disponíveis',
  				selectedListLabel: 'Produtos Selecionados',
			});
		});
	</script>

@stop
