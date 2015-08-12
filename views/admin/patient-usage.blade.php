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
	              <th>disable/enable</th>
	          </tr>
	          </thead>
	          <tbody>
	          @foreach($patient_details as $detail)
		          <tr>
		          	<td>
		          		@if ($detail['disabled'] == 1)
			        			<span class = "label label-info">{{$detail['username']}}</span>
			        			<br />
			        			<br />
			        			<span class = "label label-warning">Status : Disabled</span>
			        		@else
			        			<span class = "label label-info">{{$detail['username']}}</span>
			        			<br />
			        			<br />
			        			<span class = "label label-success">Status : Enabled</span>
			        		@endif
		          	</td>
		          	<td>{{$detail['name']}}</td>
		          	<td>{{$detail['date']}}</td>
		          	<td>{{$detail['plan_name']}}</td>
		          	<td>{{$detail['operator']}}</td>
		          	<td>{{$detail['id_proof_number']}}</td>
		          	<td><a data-toggle="lightbox" href="{{$site_url}}images/id-proofs/{{$detail['filename']}}">View Proof</a></td>
		          	<td>
		          		@if ($detail['disabled'] == 1)
		          			[<a href="admin-username-toggle-access.php?username={{$detail['username']}}&patient-id={{$patient_id}}" class="text-info">enable</a>]
		          		@else
			        			[<a href="admin-username-toggle-access.php?username={{$detail['username']}}&patient-id={{$patient_id}}" class="text-info">disable</a>]
			        		@endif
		          	</td>
		          </tr>
	          @endforeach


	          </table>
	          </div>
	          <p class="clearfix"></p>
		          <button class="btn btn-primary print"><i class="fa fa-print"></i> Print</button>
	          </div>
	      </section>
	  </div>
	</div>

	<div class="print-patient-usage">
		<h4>Details of Patient ID - {{$patient_id}}</h4>
    <table  class="table table-bordered table-striped">
      <thead>
      <tr>
          <th>Username(s)</th>
          <th>Received by</th>
          <th>Date</th>
          <th>Plan</th>
          <th>Issued by</th>
          <th>ID proof number</th>
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
        </tr>
      @endforeach


      </table>

	</div><!-- /.print-patient-usage -->
@stop