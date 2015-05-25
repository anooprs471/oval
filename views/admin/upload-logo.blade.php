@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-sm-8">

	      <section class="panel">
	          <header class="panel-heading">
	              Logo
	          </header>
	          <div class="panel-body">
							<div class="logo">

								<img src="{{ $site_url }}images/client-files/{{ $logo_big }}">
							</div><!-- /.logo -->
							<hr />
							<div class="upload-logo">
								<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">

									<input type="file" name="logo-file" id="" />
									<button class="btn btn-success">Upload</button>


								</form>
							</div><!-- /.upload-logo -->
	          </div>
	      </section>
	  </div>
	</div>
@stop