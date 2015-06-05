@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-md-12">
	  		@if($msg != '')
          <div class="alert alert-danger">{{$msg}}</div>
          <p></p>
        @endif
        @if($flash != '')
          <div class="alert alert-success ">{{$flash}}</div>
          <p></p>
        @endif

	  </div>
	  <div class="col-md-12">
	      <section class="panel">
	        <header class="panel-heading">
	            Coupon Stats

	        </header>
	        <div class="panel-body">
	        	<div class="print-username-stat">

		        	<h4>username : {{$username}}</h4>
		        	<hr />
		        	@if(!$cuopon_err)
			            <table class="table  table-hover general-table table-bordered">
			                <thead>
				                <tr>
				                    <th>Usage Started</th>
				                    <th>Usage Stopped</th>
				                    <th>Session Time</th>
				                    <th>Data Traffic(Up/Down)</th>
				                </tr>
			                </thead>
			                <tbody>
												@foreach($stats as $stat)
					                <tr>
															<td>{{$stat['acctstarttime']}}</td>
															<td>{{$stat['acctstoptime']}}</td>
															<td>
																@if(gmdate('H', $stat['acctsessiontime']) > 0)
																	{{ gmdate('H', $stat['acctsessiontime']) }} hr
																@endif
																@if(gmdate('i', $stat['acctsessiontime']) > 0)
																	{{ gmdate('i', $stat['acctsessiontime']) }} mins
																@endif
																@if(gmdate('s', $stat['acctsessiontime']) > 0)
																	{{ gmdate('s', $stat['acctsessiontime']) }} secs
																@endif
															<td>{{$stat['total_download']}}</td>
					                </tr>
				                @endforeach

			                </tbody>
			            </table>
			        @else
			        	no stats for the coupon
			        @endif
	        	</div><!-- /.print-username-stat -->
	        	<button class="btn btn-primary print"><i class="fa fa-print"></i> Print</button>
	        </div>
	    </section>
	  </div>
	</div>
@stop