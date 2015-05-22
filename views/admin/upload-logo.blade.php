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
								Current Logo
							</div><!-- /.logo -->
							<div class="upload-logo">
								<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
								<input type="file" name="logo-file" id="" />
								<button class="btn btn-default">Upload</button>
								</form>
							</div><!-- /.upload-logo -->
	          </div>
	      </section>
	  </div>
	</div>
@stop