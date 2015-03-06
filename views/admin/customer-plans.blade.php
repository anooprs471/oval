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
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Plan Name</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($current_plans as $plan)
	                        <tr>
	                            <td></td>
	                            <td>{{$plan['planname']}}</td>
	                            <td>
	                            	<form class=" form-inline" method="POST" action="">
		                            	<div class="form-group">
		                            		<input type="hidden" value="{{$plan['id']}}" name="plan-id" />
		                            		<input type="hidden" value="update" name="form-type" />
	                                	<input type="text" name="price" id="" class="form-control" value="{{$plan['price']}}">
	                            		</div>
	                            		<button class="btn btn-success" type="submit">Update Price</button>
	                            	</form>
	                            	
	                            </td>
	                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </section>

            <hr />
            <section class="panel">
                <header class="panel-heading">
                    Add Available Plans for Operators
                    
                </header>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Plan Name</th>
                            <th>Price</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($to_add_plans as $plan)
	                        <tr>
	                            <td></td>
	                            <td>{{$plan}}</td>
	                            <td>
	                            	<form class=" form-inline" method="POST" action="">
		                            	<div class="form-group">
	                                	<input type="hidden" value="add-plan" name="form-type" />
	                                	<input type="hidden" value="{{$plan}}" name="plan-name" />
	                                	<input type="text" name="price" class="form-control" value="">
	                            		</div>
	                            		<button class="btn btn-success" type="submit">Add</button>
	                            	</form>
	                            </td>
	                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </section>

	          </div>
	      </div>
	  </section>

	</div>
@stop