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
	      <section class="panel">
	          <div class="panel-body profile-information">
	             <div class="col-md-7">
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

	             <div class="col-md-5">
					          
			            <p>Coupons</p>

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
                          <td>{{$coupon['date']}}</td>
                          <td>{{$coupon['plan']}}</td>
                      </tr>
                      @endforeach
           
                      </tbody>
                  </table>
	             </div><!-- /.col-md-5 -->
	             
	             
	          </div>
	      </section>
	  </div>

	</div>
@stop