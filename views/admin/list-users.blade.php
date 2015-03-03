@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-sm-12">
	      <section class="panel">
	          <header class="panel-heading">
	              Users
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
										<a href="{{$site_url}}admin-suspend-user.php?id={{$id}}">Suspend User</a>
	              	@else
										<a href="{{$site_url}}admin-activate-user.php?id={{$id}}">Activate User</a>	
	              	@endif

		              </td>
		              
		          </tr>
	          @endforeach


	          </table>
	          </div>
	          </div>
	      </section>
	  </div>
	</div>
@stop