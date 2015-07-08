@extends('layout')

@section('content')
	<div class="row">
		<form class="form-horizontal " action="" method="post">

		<div class="row">
			<div class="col-md-6">
			  <div class="form-group">
			      <label class="control-label col-md-5">Load Backup from</label>
			      <div class="col-md-7">
			          <input type="text" value="" size="16" name="backup-date" class="form-control form-control-inline input-medium default-date-picker">
			          <span class="help-block">Select date</span>
			      </div>
			  </div>
			</div><!-- /.col-md-8 -->
			<div class="col-md-4">
				<div class="form-group">
              <button class="btn btn-danger" type="submit">Load</button>
	      </div>
			</div><!-- /.col-md-4 -->
		</div><!-- /.row -->



    </form>
	  <div class="col-sm-12">


	      <section class="panel">
          <header class="panel-heading">
              Table
          </header>
          <div class="panel-body">
            <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="dynamic-table">
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
            </tbody>
            </table>
            </div>
          </div>
        </section>


	  </div>
	</div>

	<!-- /.print-username-details -->
@stop