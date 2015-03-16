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


	        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <div class="panel-body invoice">
                        <div class="invoice-header">
                            <div class="invoice-title col-md-5 col-xs-2">
                                    <h1>Coupon</h1>
                                    
                            </div>
                            
                        </div>
                        
                        <table class="table table-invoice" >
                            
                            <tbody>
                                <tr>
                                    <td class="text-right">Username</td>
                                    <td class="text-left">{{$coupon_details['username']}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Password</td>
                                    <td class="text-left">{{$coupon_details['password']}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Plan</td>
                                    <td class="text-left">{{$coupon_details['plan_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Price</td>
                                    <td class="text-left">{{$coupon_details['price']}}</td>
                                </tr>
                                <tr>
                                    <td class="text-right">Date</td>
                                    <td class="text-left">{{$coupon_details['coupon_date']}}</td>
                                </tr>
                                
                                

                            </tbody>
                        </table>
                        
                    </div>
                </section>
            </div>
        </div>
	        </div><!-- /.print-coupon -->

	        <button class="btn btn-primary print"><i class="fa fa-print"></i> Print Coupon</button>
	        
	      @endif 
    </div>
  </div><!-- .row-->

@stop