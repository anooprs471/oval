@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-sm-12">
	      <section class="panel">
	          <header class="panel-heading">
	              Weblog
	          </header>
	          <div class="panel-body">
		          <div class="adv-table">
		          <table  class="display table table-bordered table-striped" id="dynamic-table11">
		          <thead>
		          <tr>
		              <th>Username</th>
		              <th>MAC Address</th>
		              <th>Visited Website</th>
		              <th>Date</th>
		          </tr>
		          </thead>
		          <tbody>
		          @foreach($weblog as $row)
			          <tr>
			          	<td>{{$row['username']}}</td>
			          	<td>{{$row['callingstationid']}}</td>
			          	<td>{{$row['request_url']}}</td>
			          	<td>{{$row['DATE(FROM_UNIXTIME(a.time_since_epoch))']}}</td>
			          </tr>
		          @endforeach


		          </table>
		          </div>

	          </div>

	      </section>
	  </div>
	</div>

	<!-- /.print-username-details -->
@stop