@extends('layout')

@section('content')


	<div class="col-lg-12">
		@if($msg != '')
		  <div class="alert alert-danger">{{$msg}}</div>
		  <p></p>
		@endif
		@if($flash != '')
		  <div class="alert alert-success ">{{$flash}}</div>
		  <p></p>
		@endif
	  <section class="panel">
	      <header class="panel-heading">
	          Coupons
	      </header>
	      <div class="panel-body">
	          <div class="position-center1">
		          @if($msg != '')
			          <div class="alert alert-danger">{{$msg}}</div>
		          @endif  
		          <section class="panel">
                <header class="panel-heading">
                    Current Plans
                    
                </header>
                <div class="panel-body">
                		@if(!empty($priced_plans))
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Plan Name</th>
                            <th>Price</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($priced_plans as $plan)
	                        <tr>
	                            <td></td>
	                            <td>{{$plan['planname']}}</td>
	                            <td>
	                            	<form class=" form-inline" method="POST" action="">
		                            	<div class="form-group">
		                            		<input type="hidden" value="{{$plan['planname']}}" name="plan-name" />
		                            		<input type="hidden" value="update" name="form-type" />
	                                	<input type="text" name="price" id="" class="form-control" value="{{$plan['price']}}">
	                            		</div>
	                            		<button class="btn btn-success" type="submit">Update Price</button>
	                            	</form>
	                            	
	                            </td>
	                            <td>
	                            	<form class=" form-inline" method="GET" action="admin-edit-plan.php">
		                            		<input type="hidden" value="{{$plan['planname']}}" name="plan-name" />
		                            		<button class="btn btn-danger" type="submit">Edit</button>
	                            	</form>
	                            </td>
	                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                    @else
                    	<p>No plans available, please add from control panel</p>
                    @endif	
                </div>
            </section>


	          </div>
	      </div>
	  </section>

	</div>
@stop