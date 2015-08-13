
@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-md-12">
	  		@if($msg != '')
          <div class="alert alert-danger">{{$msg}}</div>
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
	          @if(!$customer_err && !$id_err)
		          <div class="panel-body">
		              <div class="tab-content tasi-tab">

											<div id="customer-details" class="tab-pane active">
		                      <div class="row">
		                      	<div class="col-md-6">
		                      	<div class="row">
														    <div class="col-md-12">
														        <section class="panel">
														            <header class="panel-heading">
														                Customer Details
														            </header>
														            <div class="panel-body">
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
									                      				<p><a data-toggle="lightbox" href="{{$site_url}}images/id-proofs/{{$form['image-file']}}"><span class="label label-info">View ID Proof</span></a></p>
									                      			</div><!-- /.col-md-8 -->
									                        </div>
														            </div>
														        </section>
														        <!--modal end-->
														    </div>
														</div>



		                      		<hr />

		                      		<div class="pre-coupons">
		                      		<div class="row">
														    <div class="col-md-12">
														        <section class="panel">
														            <header class="panel-heading">
														                Previous Coupons
														            </header>
														            <div class="panel-body">
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
							                                    <td>{{ucwords($coupon['name'])}}</td>
							                                    <td>{{$coupon['date']}}</td>
							                                    <td>
							                                    	@if($coupon['complementary'] == 1)
							                                    		Complimentary
							                                    	@else
							                                    		{{$coupon['plan']}}
							                                    	@endif
							                                    </td>
							                                </tr>
								                      			@endforeach
								                      			</tbody>
							                            </table>
								                      		@else
								                      			no previous coupons purchased!
								                      		@endif
														            </div>
														        </section>
														    </div>
														  </div>


		                      		</div><!-- /.pre-coupons -->



		                      	</div><!-- /.col-md-6 -->
		                      	<div class="col-md-6">
		                      	<div class="row">
		                      		<div class="col-md-12">
		                      			<section class="panel">
		                      				<header class="panel-heading">
		                      					Available Plans
		                      				</header><!-- /.panel-heading -->
		                      				<div class="panel-body">
		                      				@if($flash != '')
													          <div class="alert alert-danger">{{$flash}}</div>
													          <p></p>
													        @endif
		                      					<form method="POST" action="op-generate-coupon.php">
					                      		@if(!empty($coupon_plans))

					                      		<div class="form-group">
																			<label class="col-lg-4 col-sm-2 control-label text-right" style="margin-top:10px">Plans</label>
																			<div class="col-lg-8">
						                      			@foreach($coupon_plans as $plan)
						                      				<div class="radio">
							                                <label>
							                                    <input type="radio" checked="" value="{{$plan['plan']}}" name="plan-type">
							                                    {{$plan['plan']}} <strong>Rs {{$plan['price']}} /-</strong>
							                                </label>
							                            </div>
						                      			@endforeach
					                      			</div>
				                      			</div>

					                      			<div class="form-group">
																		      <label class="col-lg-4 col-sm-2 control-label text-right">Coupon Valid till</label>
																		      <div class="col-lg-8">
																		          <input class="form-control form-control-inline input-medium default-date-picker"  size="16" type="text" value="" name="coupon-valid-till" />
														                  <span class="help-block">Select date</span>
																		      </div>
																		  </div>

					                      			<input type="hidden" name="customer-id" value="{{$customer_id}}" />
					                      			<div class="form-group">
					                      				<button class="btn btn-primary btn-lg pull-right" type="submit">
					                      			Generate Coupon</button>
					                      			</div>
					                      			@else
					                      			<p>Sorry no coupons plans made available now</p>
					                      			@endif
					                      		</form>

		                      				</div><!-- /.panel-body -->
		                      			</section><!-- /.panel -->
		                      		</div><!-- /.col-md-12 -->
		                      	</div><!-- /.row -->

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
