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
    	<form method="POST" action="">
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
	    <hr />
	    @if($total_pages > 2)
	     <div class="text-center">
		      <ul class="pagination">
		      	@for ($i = 0; $i < $total_pages; $i++)
		      		 <li class="{{$current_page-1 == $i ? 'active' : ''}}">
			      		 	<a href="{{ $site_url }}admin-batch-details.php?batch-id={{$batch_id}}&page={{$i+1}}">
			      		 	{{$i+1}}
			      		 	</a>
		      		 </li>
		      	@endfor
		      </ul>
		  </div>
		  @endif
		  <p>

	    	<a href="" class="batch-coupon-checkall"><i class="fa fa-check"></i> Check All</a> | <a href="" class="batch-coupon-uncheckall"><i class="fa fa-times"></i> Uncheck All</a>

	    </p>
	    <hr />
	    <input type="hidden" value="{{ $batch_id }}" name="batch-id" />
	    <button type="submit" class="btn btn-primary">Add Coupons To Print</button>
	    @if ($selected > 0)
	    	<button type="submit" class="btn btn-success"><i class="fa fa-print"> </i> Print Coupons</button>
	    @endif
    	</form>
	  @else
    	no coupons
    @endif


		</div><!-- /.panel-body -->
</section><!-- /.panel -->
</div><!-- /.col-md-8 -->


@stop