@extends('layout')

@section('content')
	
<div class="col-md-10">
	
<section class="panel">
		<header class="panel-heading">
				Create Plan

		</header>
		<div class="panel-body">
				<form class="form-horizontal bucket-form" method="post">

						@if(!empty($errors))
							<div class="alert alert-block alert-danger fade in">
								@foreach($errors as $error)
									{{ $error }} <br />
								@endforeach
							</div><!-- /.alert alert-block alert-danger fade in -->
						@endif
						<div class="form-group">
								<label class="col-sm-3 control-label">Plan Name</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="plan-name" value="{{ $form_data['plan-name'] }}">
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-3 control-label">Price</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="price" value="{{ $form_data['price'] }}">
								</div>
						</div>

						<hr />
						<h4>Plan Attributes</h4>
						<hr />
						<div class="form-group">
								<label class="col-sm-3 control-label">Download speed</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="download-speed" value="{{ $form_data['download-speed'] }}">
										<span class="help-block"></span>
								</div>
						</div><!-- /.form-group -->	

						<div class="form-group">
								<label class="col-sm-3 control-label">Upload speed</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="upload-speed" value="{{ $form_data['upload-speed'] }}">
										<span class="help-block"></span>
								</div>
						</div><!-- /.form-group -->	

						<div class="form-group">
								<label class="col-sm-3 control-label">Max data usage<br />
								(Total Data consumption)</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="max-data-usage" value="{{ $form_data['max-data-usage'] }}">
										<span class="help-block"></span>
								</div>
						</div><!-- /.form-group -->	

						<div class="form-group">
								<label class="col-sm-3 control-label">Max all session<br />
								(Total duration)</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="max-all-session" value="{{ $form_data['max-all-session'] }}">
										<span class="help-block"></span>
								</div>
						</div><!-- /.form-group -->	

						<div class="form-group">
								<label class="col-sm-3 control-label">Max daily session<br />
								(Daily duration)</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="max-daily-session" value="{{ $form_data['max-daily-session'] }}">
										<span class="help-block"></span>
								</div>
						</div><!-- /.form-group -->	

						<div class="form-group">
								<label class="col-sm-3 control-label">Simultaneous use</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="simult-use" value="{{ $form_data['simult-use'] }}">
										<span class="help-block"></span>
								</div>
						</div><!-- /.form-group -->	

						<div class="form-group">
								<label class="col-sm-3 control-label">Idle timeout </label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="idle-timeout" value="{{ $form_data['idle-timeout'] }}">
										<span class="help-block"></span>
								</div>
						</div><!-- /.form-group -->	
						<div class="form-group">
								<div class="col-sm-6 col-sm-offset-3">
										<button type="submit" class="btn btn-success">Save Plan</button>
								</div>
						</div><!-- /.form-group -->	
				</form>
		</div><!-- /.panel-body -->	
</section><!-- /.panel -->	
</div><!-- /.col-md-8 -->	


@stop