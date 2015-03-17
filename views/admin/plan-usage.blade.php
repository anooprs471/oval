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
	          @if(!$form_err)

	          <table  class="display table table-bordered table-striped" id="dynamic-table">
	          <thead>
	          <tr>
	              <th>Date</th>
	              <th>Username</th>
	              <th>Operator</th>
	          </tr>
	          </thead>
	          <tbody>
	          @foreach($plans as $plan)
		          <tr>
		          	<td>{{$plan['date']}}</td>
		          	<td>
		          	<a href="{{$site_url}}admin-username-details.php?username={{$plan['username']}}">{{$plan['username']}}</a>
		          	</td>
		          	<td>
		          		<a href="{{$site_url}}admin-user-detail.php?id={{$plan['op_id']}}">{{$plan['operator']}}</a>
		          		
		          	</td>

		          </tr>
	          @endforeach


	          </table>
	          @else
	          	<div class="">
	          		Nothing to show
	          	</div>
	          @endif	
	          </div>
	          </div>
	      </section>
	  </div>
	</div>
@stop