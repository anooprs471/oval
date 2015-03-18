@extends('layout')

@section('content')
	<div class="col-lg-6">
	  <section class="panel">
	      <header class="panel-heading">
	          Create User
	      </header>
	      <div class="panel-body">
	          <div class="position-center">
							@if($msg != '')
					      <div class="alert alert-danger">{{$msg}}</div>
					      <p></p>
					    @endif
					    @if($flash != '')
					      <div class="alert alert-success ">{{$flash}}</div>
					      <p></p>
					    @endif
	              <form class="form-horizontal" role="form" method="POST" action="">
	              <div class="form-group">
	                  <label for="inputEmail1" class="col-lg-2 col-sm-2 control-label">Username</label>
	                  <div class="col-lg-10">
	                      <input type="text" class="form-control" id="inputEmail1" placeholder="Username" name="username">
	                      
	                  </div>
	              </div>
	              <div class="form-group">
	                  <label for="inputPassword1" class="col-lg-2 col-sm-2 control-label">Password</label>
	                  <div class="col-lg-10">
	                      <input type="text" class="form-control" id="inputPassword1" placeholder="Password" name="password">
	                  </div>
	              </div>
	              
	              <div class="form-group">
	                  <div class="col-lg-offset-2 col-lg-10">
	                      <button type="submit" class="btn btn-danger">Create a user</button>
	                  </div>
	              </div>
	          </form>
	          </div>
	      </div>
	  </section>

	</div>
@stop