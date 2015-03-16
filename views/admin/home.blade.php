@extends('layout')

@section('content')

	<div class="row">
	  <div class="col-sm-6">
	      <section class="panel">
	          <header class="panel-heading">
	              Operators
	          </header>
	          <div class="panel-body">
	          <div class="adv-table">
	          <table  class="display table table-bordered table-striped" id="dynamic-table">
	          <thead>
	          <tr>
	              <th>Username</th>
	              <th>Action(s)</th>
	          </tr>
	          </thead>
	          <tbody>
	          @foreach($users as $id => $op_details)
		          <tr class="gradeC">
		              <td><a href="{{$site_url}}admin-user-detail.php?id={{$id}}">{{$op_details['username']}}</a></td>
		              <td>
	              	@if($op_details['active'])
										<a href="{{$site_url}}admin-suspend-user.php?id={{$id}}" class="label label-danger label-mini">Suspend User</a>
	              	@else
										<a href="{{$site_url}}admin-activate-user.php?id={{$id}}" class="label label-success label-mini">Activate User</a>	
	              	@endif

		              </td>
		              
		          </tr>
	          @endforeach


	          </table>
	          </div>
	          </div>
	      </section>
	  </div>
	   <div class="col-sm-6">
	   <section class="panel">
	      <header class="panel-heading">
	          Find details of username
	      </header>
        <div class="panel-body">
          <div class="position-center">
	          <div class="row">
          		<form class="form-inline" role="form" method="GET" action="admin-username-details.php">

	          	<div class="col-md-8">
			          	<div class="form-group">
                      <label class="sr-only">Username</label>
                      <input type="text" class="form-control" placeholder="Username" name="username" />
                  </div>
	          	</div><!-- /.col-md-8 -->
	          	<div class="col-md-4">
	          		 <button type="submit" class="btn btn-success">Find</button>
	          	</div><!-- /.col-md-4 -->
	          	</form>
	          </div><!-- /.row -->

          </div>
        </div>
      </section>


	   	<section class="panel">
	      <header class="panel-heading">
	          Find Patient's Usage
	      </header>
        <div class="panel-body">
          <div class="position-center">
	          <div class="row">
          		<form class="form-inline" role="form" method="GET" action="admin-patient-usage.php">

	          	<div class="col-md-8">
			          	<div class="form-group">
                      <label class="sr-only">Patient ID</label>
                      <input type="text" class="form-control" placeholder="Patient ID" name="patient-id" />
                  </div>
	          	</div><!-- /.col-md-8 -->
	          	<div class="col-md-4">
	          		 <button type="submit" class="btn btn-success">Find</button>
	          	</div><!-- /.col-md-4 -->
	          	</form>
	          </div><!-- /.row -->

          </div>
        </div>
      </section>

      <section class="panel">
          <header class="panel-heading">
              Plans Sold
          </header>
          <div class="panel-body">
            <div class="position-center">
  	          <form method="POST" action="admin-coupon-usage.php">
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

            </div>
          </div>
      </section>
	   </div>
	</div><!--row-->

	
@stop

