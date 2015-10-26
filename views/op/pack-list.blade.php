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
						<th>Issued</th>
						<th>Avilable</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($batches as $batch)
					<tr class="gradeC">
						<td>
							<a href="{{$site_url}}op-pack-details.php?batch-id={{$batch['id']}}">{{$batch['batch_name']}}</a>
						</td>
						<td>
							{{ $batch['plan'] }}
						</td>
						<td>
							{{ $batch['no_of_coupons'] }}
						</td>
						<td>
							{{ $batch['issued'] }}
						</td>
						<td>
							{{ $batch['printed'] - $batch['issued'] }}
						</td>

					</tr>
					@endforeach


				</table>
			</div><!-- /.panel-body -->
		</section><!-- /.panel -->
	</div><!-- /.col-md-8 -->


	@stop