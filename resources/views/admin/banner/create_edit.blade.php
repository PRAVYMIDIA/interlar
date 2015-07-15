@extends('admin.layouts.modal')

@section('styles')
<link href="{{{ asset('assets/admin/css/bootstrap-duallistbox.css') }}}"
	rel="stylesheet" type="text/css">

<link href="{{{ asset('assets/admin/css/datepicker3.css') }}}"
	rel="stylesheet" type="text/css">
@stop

{{-- Content --}} 
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab"> Banner</a></li>
	@if(isset($banner_edit))
	<li><a href="#tab-visitas" data-toggle="tab"> Visitas</a></li>
	@endif
</ul>
<!-- ./ tabs -->
{{-- Edit Banner Form --}}
<form class="form-horizontal" id="fupload" enctype="multipart/form-data"
	method="post"
	action="@if(isset($banner_edit)){{ URL::to('admin/banner/'.$banner_edit->id.'/edit') }}
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
							class="form-control" type="text" name="nome" id="nome"  required="required"
							value="{{{ Input::old('nome', isset($banner_edit) ? $banner_edit->nome : null) }}}" />
						{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				<div
					class="form-group {{{ $errors->has('url') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="url"> URL (Link de destino)</label> <input
							class="form-control" type="url" name="url" id="url" required="required"
							value="{{{ Input::old('url', isset($banner_edit) ? $banner_edit->url : null) }}}" />
						{!!$errors->first('url', '<label class="control-label">:message</label>')!!}
					</div>
				</div>

				<div class="row">
					<div class="col-md-4">
						<div class="form-group {{{ $errors->has('dtinicio') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="dtinicio"> Início da Exibição</label> 
								<input
									class="form-control date" type="text" name="dtinicio" id="dtinicio" required="required"
									value="{{{ Input::old('dtinicio', isset($banner_edit) ? $banner_edit->dtinicio : null) }}}" />
								{!!$errors->first('dtinicio', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{{ $errors->has('dtfim') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="dtfim"> Fim da Exibição</label> 
								<input
									class="form-control date" type="text" name="dtfim" id="dtfim" required="required"
									value="{{{ Input::old('dtfim', isset($banner_edit) ? $banner_edit->dtfim : null) }}}" />
								{!!$errors->first('dtfim', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group {{{ $errors->has('bgcolor') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="bgcolor"> Cor de fundo do banner</label> 
								<input	class="form-control" type="color" name="bgcolor" id="bgcolor" 
										value="{{{ Input::old('bgcolor', isset($banner_edit) ? $banner_edit->bgcolor : null) }}}" />
								{!!$errors->first('bgcolor', '<label class="control-label">:message</label>')!!}
							</div>
						</div>
					</div>
				</div>
				
				<div
					class="form-group {{{ $errors->has('html') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="html">HTML</label>
						<textarea class="form-control full-width wysihtml5" name="html"
							value="html" rows="10">{{{ Input::old('html', isset($banner_edit) ? $banner_edit->html : null) }}}</textarea>
						{!! $errors->first('html', '<label class="control-label">:message</label>')
						!!}
					</div>
				</div>
				@if((isset($banner_edit) ? $banner_edit->imagem : '')!='' )
				<div class="form-group center-block">
					<a href="/images/banner/{{$banner_edit->id.'/'.$banner_edit->imagem }}" target="_blank"><img class="img-responsive img-thumbnail center-block" title="imagem atual" src="/images/banner/{{$banner_edit->id.'/'.$banner_edit->thumb()}}" alt="Imagem atual"></a>
				</div>
				@endif
				<div
					class="form-group {{{ $errors->has('imagem') ? 'error' : '' }}}">
					<div class="col-lg-12">
						<label class="control-label" for="imagem">{{ (isset($banner_edit) ? $banner_edit->imagem : '')!=''?'Trocar ':'Inserir ' }}Imagem</label> <input name="imagem"
							type="file" class="uploader" id="imagem" value="Upload" />
					</div>

				</div>
				<!-- ./ general tab -->
			</div>
			<!-- ./ tabs content -->
			
			@if(isset($banner_edit))
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
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 1 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 2 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 3 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 4 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 5 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 6 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 7 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 8 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) = '.$i.' AND MONTH(created_at) = 9 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) =  '.$i.' AND MONTH(created_at) = 10 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) =  '.$i.' AND MONTH(created_at) = 11 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
			          <td><span class="label label-default">{{ $banner->visitas()->whereRaw('DAY(created_at) =  '.$i.' AND MONTH(created_at) = 12 AND YEAR(created_at) = '.date('Y') )->count() }}</span></td>
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
					<button type="submit" class="btn btn-sm btn-success">
						<span class="glyphicon glyphicon-ok-circle"></span> 
						@if	(isset($banner_edit)) 
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
	<script src="{{  asset('assets/admin/js/bootstrap-datepicker.js') }}"></script>
	<script src="{{  asset('assets/admin/js/bootstrap-datepicker.pt-BR.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function($) {
			var bootstrapduallist = $('select[name="produto_banner[]"]').bootstrapDualListbox({
				 nonSelectedListLabel: 'Produtos Disponíveis',
  				selectedListLabel: 'Produtos Selecionados',
			});

			$('.date').datepicker({
			    format: "dd/mm/yyyy",
			    language: "pt-BR",
			    todayHighlight: true
			});
		});
	</script>

@stop
