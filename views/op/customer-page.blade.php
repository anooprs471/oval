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
	                          Cutomer
	                      </a>
	                  </li>
	                  <li>
	                      <a data-toggle="tab" href="#prev-coupons">
	                          Previous Coupons Issued
	                      </a>
	                  </li>

	                  <li>
	                      <a data-toggle="tab" href="#settings">
	                          Settings
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

		                      		<div class="row">
		                      			<div class="col-md-4">
		                      				Patient ID
		                      			</div><!-- /.col-md-4 -->
		                      			<div class="col-md-8">
		                      				{{$form['patient_id']}}
		                      			</div><!-- /.col-md-8 -->
		                      		</div><!-- /.row -->

															<div class="row">
		                      			<div class="col-md-4">
		                      				Cutomer Name
		                      			</div><!-- /.col-md-4 -->
		                      			<div class="col-md-8">
		                      				{{$form['customer_name']}}
		                      			</div><!-- /.col-md-8 -->
		                      		</div><!-- /.row -->

		                      		<div class="row">
		                      			<div class="col-md-4">
		                      				ID Proof
		                      			</div><!-- /.col-md-4 -->
		                      			<div class="col-md-8">
		                      				{{-- <img src="images/id-proofs/{{$form['image-file']}}"><br />{{$form['id_proof_type']}} --}}
		                      				<a data-toggle="lightbox" href="{{$site_url}}images/id-proofs/{{$form['image-file']}}">View ID Proof</a>
		                      			</div><!-- /.col-md-8 -->
		                      		</div><!-- /.row -->



		                      	</div><!-- /.col-md-6 -->
		                      	<div class="col-md-6">
		                      		<form method="POST" action="op-generate-coupon.php">

		                      			@foreach($coupon_plans as $plan)
		                      				<div class="radio">
			                                <label>
			                                    <input type="radio" checked="" value="{{$plan['id']}}" name="plan-id">
			                                    {{$plan['planname']}} <strong>Rs {{$plan['price']}} /-</strong>
			                                </label>
			                            </div>
		                      			@endforeach
		                      			
		                      			<input type="hidden" name="customer-id" value="{{$customer_id}}" />
		                      			<button class="btn btn-primary btn-lg" type="submit">Generate Coupon</button>
		                      		</form>
		                      	</div><!-- /.col-md-6 -->
		                      </div><!-- /.row -->
		                  </div>
		                  <div id="prev-coupons" class="tab-pane">
		                      
		                  </div>
		                  <div id="settings" class="tab-pane ">
		                      

		                  </div>
		              </div>
		          </div>
		        @endif  
	      </section>
	  </div>
	</div>
@stop