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
								<label class="col-sm-3 control-label">Batch Name</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="batch-name" value="{{ $form_data['batch-name'] }}">
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-3 control-label">No of coupons in batch</label>
								<div class="col-sm-6">
										<input type="text" class="form-control" name="no-of-coupons" value="{{ $form_data['no-of-coupons'] }}">
								</div>
						</div>
						<div class="form-group">
								<label class="col-sm-3 control-label">Coupons Plan</label>
								<div class="col-sm-6">
									<select class="form-control" name="batch-plan">
										@foreach ($plans as $plan)
											<option value="{{$plan['id']}}">{{$plan['planname']}}</option>
										@endforeach
	                </select>
								</div>
						</div>


						<div class="form-group">
								<div class="col-sm-6 col-sm-offset-3">
										<button type="submit" class="btn btn-success">Create Batch</button>
								</div>
						</div><!-- /.form-group -->
				</form>
		</div><!-- /.panel-body -->
</section><!-- /.panel -->
</div><!-- /.col-md-8 -->


@stop