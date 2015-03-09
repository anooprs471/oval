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
				
				@if(!$data_err)
	        <div class="print-coupon">
						<div class="logo">
							<img src="" alt="Logo" />
						</div><!-- /.logo -->
						<div class="coupon-details">
							<div class="login-credentials">

								<div class="pr-items">
									<div class="pr-label">
										Username
									</div>
									<div class="pr-item">
										{{$coupon_details['username']}}
									</div>
								</div>
									
								<div class="pr-items">
									<div class="pr-label">
										Password
									</div>
									<div class="pr-item">
										{{$coupon_details['password']}}
									</div>
								</div>

							</div><!-- /.login-credentials -->

							<div class="plan">
								Plan Name : {{$coupon_details['plan_name']}}
							</div><!-- /.plan -->
							
							<div class="price">
								Coupon Price : {{$coupon_details['price']}}
							</div><!-- /.price -->

							<div class="date">
								Coupon Price : {{$coupon_details['coupon_date']}}
							</div><!-- /.date -->
						</div><!-- /.coupon-details -->
	        </div><!-- /.print-coupon -->
	        <button class="btn btn-primary print"><i class="fa fa-print"></i> Print Coupon</button>
	      @endif 
    </div>
  </div><!-- .row-->

@stop