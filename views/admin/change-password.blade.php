@extends('layout')

@section('content')
	<div class="row">

	  <div class="col-sm-8">

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
	              Change Password
	          </header>
	          <div class="panel-body">
		          		<form class="form-horizontal" role="form" method="POST" action="">
				              <div class="form-group">
				                  <label class="col-lg-4 col-sm-2 control-label">Old Password</label>
				                  <div class="col-lg-8">
				                      <input type="password" class="form-control" placeholder="Old password" name="old-password">
				                      
				                  </div>
				              </div>
				              <div class="form-group">
				                  <label class="col-lg-4 col-sm-2 control-label">New Password</label>
				                  <div class="col-lg-8">
				                      <input type="password" class="form-control"  placeholder="New Password" name="new-password">
				                  </div>
				              </div>
				              
				              <div class="form-group">
				                  <div class="col-lg-offset-4 col-lg-8">
				                      <button type="submit" class="btn btn-danger">Change Password</button>
				                  </div>
				              </div>
				          </form>
	          </div>
	      </section>
	  </div>
	</div>
@stop