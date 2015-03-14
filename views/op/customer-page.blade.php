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
	          <header class="panel-heading tab-bg-dark-navy-blue">
	              <ul class="nav nav-tabs nav-justified ">
			              <li class="active">
	                      <a data-toggle="tab" href="#customer-details">
	                          Customer
	                      </a>
	                  </li>

	              </ul>
	          </header>
	          @if(!$customer_err)
		          <div class="panel-body">
		              <div class="tab-content tasi-tab">

											<div id="customer-details" class="tab-pane active">
		                      <div class="row">
		                      	<div class="col-md-6">

		                      		<div class="row invoice-to">
				                      		<div class="col-md-4">
			                      				<h4>Patient ID</h4>
			                      			</div><!-- /.col-md-4 -->
			                      			<div class="col-md-8">
			                      				<h4>{{$form['patient_id']}}</h4>
			                      			</div><!-- /.col-md-8 -->
			                        </div>

			                        <div class="row invoice-to">
				                      		<div class="col-md-4">
			                      				<h4>Cutomer Name</h4>
			                      			</div><!-- /.col-md-4 -->
			                      			<div class="col-md-8">
			                      				<h4>{{$form['customer_name']}}</h4>
			                      			</div><!-- /.col-md-8 -->
			                        </div>

			                        <div class="row invoice-to">
				                      		<div class="col-md-4">
			                      				<h4>ID Proof No</h4>
			                      			</div><!-- /.col-md-4 -->
			                      			<div class="col-md-8">
			                      				<h4>{{$form['id_proof_number']}}</h4>
			                      				<p><a data-toggle="lightbox" href="{{$site_url}}images/id-proofs/{{$form['image-file']}}">View ID Proof</a></p>
			                      			</div><!-- /.col-md-8 -->
			                        </div>

		                      		<hr />

		                      		<div class="pre-coupons">
		                      			<h2>Previous Coupons</h2>
		                      			@if(!$no_coupons)
																<table class="table table-bordered">
	                                <thead>
		                                <tr>
	                                    <th>Username</th>
	                                    <th>Date</th>
	                                    <th>Type</th>
		                                </tr>
	                                </thead>
	                                <tbody>

			                      			@foreach($previous_coupons as $coupon)
		                                <tr>
		                                    <td>{{$coupon['username']}}</td>
		                                    <td>{{$coupon['created_at']}}</td>
		                                    <td>
		                                    	@if($coupon['complementary'] == 1)
		                                    		Complimentary
		                                    	@else
		                                    		{{$coupon['created_at']}}
		                                    	@endif
		                                    </td>
		                                </tr>
			                      			@endforeach
			                      			</tbody>
		                            </table>
			                      		@else
			                      			no previous coupons purchased!
			                      		@endif
		                      		</div><!-- /.pre-coupons -->

                                

		                      	</div><!-- /.col-md-6 -->
		                      	<div class="col-md-6">
		                      		<form method="POST" action="op-generate-coupon.php">

		                      			@foreach($coupon_plans as $plan)
		                      				<div class="radio">
			                                <label>
			                                    <input type="radio" checked="" value="{{$plan['plan']}}" name="plan-type">
			                                    {{$plan['plan']}} <strong>Rs {{$plan['price']}} /-</strong>
			                                </label>
			                            </div>
		                      			@endforeach
		                      			
		                      			<input type="hidden" name="customer-id" value="{{$customer_id}}" />
		                      			<button class="btn btn-primary btn-lg" type="submit">Generate Coupon</button>
		                      		</form>
		                      	</div><!-- /.col-md-6 -->
		                      </div><!-- /.row -->
		                  </div>

		              </div>
		          </div>
		        @endif  
	      </section>
	  </div>
	</div>
@stop