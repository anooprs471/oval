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
	              <th>Username(s)</th>
	              <th>Received by</th>
	              <th>Date</th>
	              <th>Plan</th>
	              <th>Issued by</th>
	              <th>ID proof number</th>
	              <th>ID proof file</th>
	          </tr>
	          </thead>
	          <tbody>
	          @foreach($patient_details as $detail)
		          <tr>
		          	<td>{{$detail['username']}}</td>
		          	<td>{{$detail['name']}}</td>
		          	<td>{{$detail['date']}}</td>
		          	<td>{{$detail['plan_name']}}</td>
		          	<td>{{$detail['operator']}}</td>
		          	<td>{{$detail['id_proof_number']}}</td>
		          	<td>{{$detail['filename']}}</td>
		          </tr>
	          @endforeach


	          </table>
	          </div>
	          </div>
	      </section>
	  </div>
	</div>
@stop