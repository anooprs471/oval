@extends('layout')

@section('content')

<div class="col-md-10">

	<section class="panel">
		<header class="panel-heading">
			Pack Coupon List

		</header>
		<div class="panel-body">
			@if($msg != '')
			<div class="alert alert-danger">{{$msg}}</div>
			<p></p>
			@endif
			@if($flash != '')
			<div class="alert alert-success ">{{$flash}}</div>
			<p></p>
			@endif

			@if (!empty($batch))
			<h2>{{strtoupper($batch[0]['batch_name'])}}</h2>
			<h3>Plan : {{strtoupper($batch[0]['planname'])}}</h3>
			@endif


			@if ($selected > 0)
			<div class="alert alert-info fade in">
				<button type="button" class="close close-sm" data-dismiss="alert">
					<i class="fa fa-times"></i>
				</button>
				<strong>You have selected</strong> {{ $selected }} coupons to print.
			</div>
			@endif

			@if (count($coupons) > 0)
			<?php $check = 0;?>
			<form method="POST" action="">
				<table  class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>sl #</th>
							<th>Coupon</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($coupons as $coupon)
						<tr class="gradeC">
							<td>{{$coupon['batch_serial_number']}}</td>
							<td>
								@if ($coupon['status'] == 0)
								<label>
									<input type="checkbox" name="coupon_id[]" value="{{ $coupon['id'] }}" class="check-coupon" > {{ strtoupper($coupon['coupon']) }}
								</label>
								@elseif ($coupon['status'] == 2)
								<a href="{{$site_url}}admin-username-details.php?username={{$coupon['coupon']}}" class="inv-label">
									<strong>{{strtoupper($coupon['coupon'])}}</strong>
								</a>
								@else
								{{strtoupper($coupon['coupon'])}}
								@endif

							</td>
							<td>
								<form method="post">
									<input type="hidden" name="batch-id" value="{{ $batch_id }}" />
									<input type="hidden" name="coupon-id" value="{{ $coupon['id'] }}" />
									<button>Issue Coupon</button>
								</form>
							</td>
						</tr>
						@endforeach

					</tbody>
				</table>
				<hr />
				@if($total_pages > 1)
				<div class="text-center">
					<ul class="pagination">
						@for ($i = 0; $i < $total_pages; $i++)
						<li class="{{$current_page-1 == $i ? 'active' : ''}}">
							<a href="{{ $site_url }}op-pack-details.php?batch-id={{$batch_id}}&page={{$i+1}}">
								{{$i+1}}
							</a>
						</li>
						@endfor
					</ul>
				</div>
				@endif


			</form>

			<hr />
			<form method="post" action="op-pack-activate-serial.php" class="form-horizontal">
				<div class="col-md-2">
					<div class="form-group">
						<label>Serials From</label>
						<input type="text" name="from-serial" class="form-control" />
					</div>
				</div>

				<div class="col-md-2">
					<div class="form-group">
						<label>Serials To</label>
						<input type="text" name="to-serial" class="form-control" />
					</div>
				</div>
				<input type="hidden" value="{{ $batch_id }}" name="batch-id" />
				<div class="col-md-2">
					<label>&nbsp;</label><br />
					<button type="submit" class="btn btn-danger">Activate</button>
				</div>
			</form>


			@endif





		</div><!-- /.panel-body -->
	</section><!-- /.panel -->
</div><!-- /.col-md-8 -->


@stop