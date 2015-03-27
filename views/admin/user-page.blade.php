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

        @if(!$user_err)
	      <section class="panel">
	          <div class="panel-body profile-information">
	             <div class="col-md-5">
	                 <div class="profile-pic text-center">
	                     <img src="images/lock_thumb.jpg" alt=""/>
	                 </div>
	                 <hr />
	                  <div>
	                     <h1>{{$op['username']}}</h1>
	                     Total Coupons {{sizeof($coupons)}}
	                 </div>
	                 <hr />
	                 <div>
		             		<p>Change Password</p>
		                <form class="form-horizontal" role="form" method="POST" action="admin-change-op-password.php">
		                	<div class="form-group">
		                      <div class="col-lg-6">
		                          <input type="text" class="form-control" name="password" value="" placeholder="password">
		                          <input type="hidden" name="op-id" value="{{$op['id']}}" />
		                      </div>
		                      <div class="col-lg-6">
		                          <button class="btn btn-success" type="submit">Change Password</button>
		                      </div>
		                  </div>
		                </form>
		                 
		             </div>
	             </div>

	             <div class="col-md-7">
					          
			            <p>Coupons {{$data_date}}</p>

			            <table class="table table-bordered">
                      <thead>
                      <tr>
                          <th>Date</th>
                          <th>Plan</th>
                      </tr>
                      </thead>
                      <tbody>
                      @foreach($coupons as $coupon)
                      <tr>
                          <td>{{$coupon['created_at']}}</td>
                          <td>{{$coupon['coupon_type']}}</td>
                      </tr>
                      @endforeach
                      <tr>
                        <td>Payment</td>
                        <td>{{$payment}}</td>
                      </tr>
           
                      </tbody>
                  </table>
                  <p><span class="badge bg-primary">{{sizeof($coupons)}}</span> Coupons</p>
                  <hr />
                  <p>Find Coupons</p>

                  <form method="POST" action="">
                  	<input type="hidden" value="{{$user_id}}" name="user-id" />


                  	<div class="form-group">
                        <div class="col-md-12">
                            <div data-date-format="yyyy-mm-dd" data-date="" class="input-group input-large">
                                <input type="text" name="date-from" class="form-control dpd1">
                                <span class="input-group-addon">To</span>
                                <input type="text" name="date-to" class="form-control dpd2">
                            </div>
                            <span class="help-block">Select date range</span>
                        </div>
                        
                    </div>

                    <hr />

                    <p>Choose a plan</p>
                    <div class="radio">
                        <label>
                            <input type="radio" value="all" id="optionsRadios1" name="plan-type" checked="checked" >
                            All plans
                        </label>
                    </div>

                    @foreach($plans as $plan)
                    	<div class="radio">
                          <label>
                              <input type="radio" value="{{$plan['groupname']}}" id="optionsRadios1" name="plan-type">
                              {{$plan['groupname']}}
                          </label>
                      </div>
                    @endforeach
                    <hr />
                    <button class="btn btn-success" type="submit"><i class="fa fa-search"></i> Find</button>
                  </form>

	             </div><!-- /.col-md-5 -->
	             
	             
	          </div>
	      </section>
	      @endif
	  </div>

	</div>
@stop