@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-sm-12">
	      <section class="panel">
	          <header class="panel-heading">
	              Details of coupons for patient
	          </header>
	          <div class="panel-body">
	          <div class="adv-table">
	          <table  class="display table table-bordered table-striped" id="dynamic-table">
	          <thead>
	          <tr>
	              <th>Operator</th>
	              <th>Username</th>
	          </tr>
	          </thead>
	          <tbody>
	          @foreach($plans as $plan)
		          <tr>
		          	<td>{{$plan['created_at']}}</td>
		          	<td>{{$plan['username']}}</td>

		          </tr>
	          @endforeach


	          </table>
	          </div>
	          </div>
	      </section>
	  </div>
	</div>
@stop