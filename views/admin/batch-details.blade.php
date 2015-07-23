@extends('layout')

@section('content')

<div class="col-md-10">

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

    @if (count($coupons) > 0)
			<table  class="display table table-bordered table-striped">
		    <thead>
		    <tr>
		        <th>Coupon</th>
		        <th>Status</th>
		    </tr>
		    </thead>
		    <tbody>
		    @foreach ($coupons as $coupon)
		      <tr class="gradeC">
	          <td>
	          	@if ($coupon['status'] == 2)
	          		{{$coupon['coupon']}}
	          	@else
	          		<a href="{{$site_url}}admin-username-details.php?username={{$coupon['coupon']}}">{{$coupon['coupon']}}</a>
	          	@endif

	          </td>
	          <td>
	          	@if ($coupon['status'] == 0)
	          		Unused
	          	@elseif ($coupon['status'] == 1)
	          		Printed
	          	@elseif ($coupon['status'] == 2)
	          		Issued
	          	@endif
	          </td>
		      </tr>
		    @endforeach


	    </table>
	  @else
    	{{-- false expr --}}
    @endif


		</div><!-- /.panel-body -->
</section><!-- /.panel -->
</div><!-- /.col-md-8 -->


@stop