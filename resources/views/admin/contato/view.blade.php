@extends('admin.layouts.modal')

@section('styles')
<link href="{{{ asset('assets/admin/css/bootstrap-duallistbox.css') }}}"
	rel="stylesheet" type="text/css">
@stop

{{-- Content --}} 
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab"> Contato</a></li>
	<li><a href="#tab-respostas" data-toggle="tab"> Respostas Contato</a></li>
</ul>
<!-- ./ tabs -->
{{-- Edit Contato Form --}}

	
	<!-- Tabs Content -->
	<div class="tab-content">
		<!-- General tab -->
		
			<div class="tab-pane active" id="tab-general">
				
				<div
					class="form-group {{{ $errors->has('nome') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="nome"> Nome</label> <input
							class="form-control" type="text" name="nome" id="nome" readonly="readonly"
							value="{{{ Input::old('nome', isset($contato) ? $contato->nome : null) }}}" />
						{!!$errors->first('nome', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				<div
					class="form-group">
					<div class="col-md-12">
						<label class="control-label" for="email"> Email</label> <input
							class="form-control" type="text" name="email" id="email" readonly="readonly"
							value="{{{ Input::old('email', isset($contato) ? $contato->email : null) }}}" />
					</div>
				</div>
				<div
					class="form-group {{{ $errors->has('celular') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="celular"> Telefone</label> <input
							class="form-control" type="text" name="celular" id="celular" readonly="readonly"
							value="{{{ Input::old('celular', isset($contato) ? $contato->celular : null) }}}" />
						{!!$errors->first('celular', '<label class="control-label">:message</label>')!!}
					</div>
				</div>
				
				<div
					class="form-group {{{ $errors->has('mensagem') ? 'has-error' : '' }}}">
					<div class="col-md-12">
						<label class="control-label" for="mensagem">Mensagem</label>
						<textarea class="form-control full-width" readonly="readonly" name="mensagem"
							value="mensagem" rows="10">{{{ Input::old('mensagem', isset($contato) ? $contato->mensagem : null) }}}</textarea>
						{!! $errors->first('mensagem', '<label class="control-label">:message</label>')
						!!}
					</div>
				</div>
				
				
				<!-- ./ general tab -->
			</div>
			<!-- ./ tabs content -->

			<!-- Respostas tab -->
			<div class="tab-pane" id="tab-respostas">
				<form class="form-horizontal" id="fupload" enctype="multipart/form-data"
					method="post"
					action="{{ URL::to('admin/contato/create') }}"
					autocomplete="off">
					<!-- CSRF Token -->
					<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
					<!-- ./ csrf token -->
					{!! Form::hidden('contato_id',$contato->id) !!}
					
					@if(count($respostas))
						<table class="table table-hover">
					      <thead>
					        <tr>
					          <th>#</th>
					          <th>Usuário</th>
					          <th>Data</th>
					          <th>Tipo</th>
					          <th>Mensagem</th>
					        </tr>
					      </thead>
					      <tbody>
					      	@foreach($respostas as $resposta)
						     	<tr>
						          <th scope="row">{{$resposta->id}}</th>
						          <td>{{$resposta->usuario->username}}</td>
						          <td>{{$resposta->created_at}}</td>
						          <td>{{$resposta->tipo}}</td>
						          <td>{{$resposta->mensagem}}</td>
						        </tr>
					    	@endforeach
					      </tbody>
					    </table>
						
				    @endif
					
					<div class="panel panel-default">
					  <div class="panel-heading">
					    <h3 class="panel-title">Enviar Resposta</h3>
					  </div>
					  <div class="panel-body">

					  	<div class="form-group">
							<div class="col-md-12">
								<label class="control-label" for="Tipo">Tipo de Resposta</label>
								{!!  Form::select('tipo',(array('EMAIL'=>'E-MAIL','SMS'=>'SMS')),NULL,array('class'=>'form-control') );  !!}

							</div>
						</div>

					  	<div
							class="form-group {{{ $errors->has('mensagem') ? 'has-error' : '' }}}">
							<div class="col-md-12">
								<label class="control-label" for="mensagem">Mensagem</label>
								<textarea required="required" class="form-control full-width" name="mensagem"
									value="mensagem" rows="10" placeholder="Mensagem Recebida: {{{ $contato->mensagem }}}"></textarea>
		
							</div>
						</div>
				    	<div class="form-group">
				    		<span class="col-md-4 col-md-offset-4">

					    	<button type="submit" class="btn btn-sm btn-success btn-block">
								<span class="glyphicon glyphicon-ok-circle"></span> 				
								  Enviar Resposta							
							</button>
				    		</span>
				  		</div>
					  </div>
					</div>
				
			    </form>
			</div>
			<!-- ./ Respostas tab -->

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
					
				</div>
			</div>
			<!-- ./ form actions -->


@stop

@section('scripts')
	@parent
	<script src="{{  asset('assets/admin/js/jquery.bootstrap-duallistbox.js') }}"></script>
	<script type="text/javascript">
		$(document).ready(function($) {
			var bootstrapduallist = $('select[name="resposta_contato[]"]').bootstrapDualListbox({
				 nonSelectedListLabel: 'Respostas Disponíveis',
  				selectedListLabel: 'Respostas Selecionados',
			});
		});
	</script>

@stop
