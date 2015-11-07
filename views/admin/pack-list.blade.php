@extends('layout')

@section('content')

<div class="col-md-10">

	<section class="panel">
		<header class="panel-heading">
			Batch List

		</header>
		<div class="panel-body">
			@if($msg != '')
			<div class="alert alert-danger">{{$msg}}</div>
			<p></p>
			@endif
			@if($flash != '')
			<div class="alert alert-success ">{{$flash}}</div>
			<p></p>
			@endif

			<table  class="display table table-bordered table-striped" id="dynamic-table">
				<thead>
					<tr>
						<th>Batch Name</th>
						<th>Plan</th>
						<th>No of Coupons</th>
						<th>Printed</th>
						<th>Issued</th>
						<th>Created</th>
						<th>Expires on</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($batches as $batch)
					<tr class="gradeC {{ ($batch['expiry_status'])?'expired':'not-expired' }}">
						<td>
						<a href="{{$site_url}}admin-pack-details.php?batch-id={{$batch['id']}}">{{ucwords($batch['batch_name'])}}</a>
							<br />

						</td>
						<td>
							{{ ucwords($batch['plan']) }}
						</td>
						<td>
							{{$batch['no_of_coupons']}}
						</td>
						<td>
							{{$batch['printed']}}
						</td>
						<td>
							{{$batch['issued']}}
						</td>
						<td>
							{{ $batch['created_at']}}
						</td>
						<td>
							{{$batch['expires']}}
						</td>
					</tr>
					@endforeach
				</tbody>

			</table>
		</div><!-- /.panel-body -->
	</section><!-- /.panel -->
</div><!-- /.col-md-8 -->


@stop