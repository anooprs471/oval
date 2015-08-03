@extends('layout')

@section('content')

<div class="col-md-12">

<section class="panel">
		<header class="panel-heading">
				Batch List

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

		<?php $count = 0;
$total_count = 0;?>
    @if (count($coupons) > 0)


			@foreach ($coupons as $coupon)
				@if ($count == 0)
					<div style="overflow: hidden;">
	    	@endif

					<div style="width: 19%; float: left; margin: .5%">
						<div style="border: 1px solid #E3E3E3; padding: 10px;">
							<div>
                   <img src="{{$site_url}}/images/client-files/{{ $print_logo }}" style="width:100%">
              </div>
              <p>&nbsp;</p>
							<p>Username : {{ strtoupper($coupon['coupon']) }}</p>
							<p>Password : {{ strtoupper($coupon['password']) }}</p>
							<p>Plan : {{ strtoupper($coupon['planname']) }}</p>
							<p>Price : {{ strtoupper($coupon['price']) }}</p>
						</div>
					</div>
				<?php $count++;
$total_count++?>
				@if ($count == $cols || $total_count == count($coupons))
					<!--{{$count}}-->
					</div>
					<?php $count = 0;?>
				@endif

			@endforeach
	  @else
    	{{-- false expr --}}
    @endif
    <hr />

    <div class="row">
    	<div class="col-md-6">
    		<div class="row">
					<form action="admin-batch-print-template.php" method="POST" role="form" >

						@foreach ($coupon_ids as $id)
							<input type="hidden" name="coupon_id[]" value="{{$id}}" />
						@endforeach


	    			<div class="col-md-6">
	    				<div class="form-horizontal">
	    					<div class="form-group">
			            <label class="col-sm-8 control-label">No of Colums</label>
			            <div class="col-sm-4">
			                <input type="text" placeholder="" value="{{$cols}}" name="cols" class="form-control">
			            </div>
					      </div>
	    				</div><!-- /.form-horizontal -->
	    			</div><!-- /.col-md-6 -->

	    			<div class="col-md-4">
		    			<div class="form-group">
		              <div class="col-sm-offset-1 col-sm-4">
				              <button type="submit" class="btn btn-danger">Change Layout</button>
				          </div>
		          </div>
	    			</div><!-- /.col-md-4 -->
						<input type="hidden" name="batch-id" value="{{ $batch_id }}" />
					</form>
    		</div><!-- /.row -->

     	</div><!-- /.col-md-6 -->

			<div class="col-md-6">
				<form action="admin-batch-print.php" method="POST" role="form" >
					@foreach ($coupon_ids as $id)
						<input type="hidden" name="coupon_id[]" value="{{$id}}" />
					@endforeach
					<input type="hidden" value="{{$cols}}" name="cols">
					<button type="submit" class="btn btn-primary">Print This Batch</button>
				</form>
			</div><!-- /.col-md-6 -->

    </div><!-- /.row -->




	</div><!-- /.panel-body -->
</section><!-- /.panel -->
</div><!-- /.col-md-8 -->


@stop