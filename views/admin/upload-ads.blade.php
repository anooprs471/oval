@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-sm-8">

	      <section class="panel">
	          <header class="panel-heading">
	              Login Screen Right Ad
	          </header>
	          <div class="panel-body">
								<div class="ad-show">
									<img src="{{ $site_url }}images/client-files/{{ $ad_login_right }}">
								</div><!-- /.ad-show -->
								<hr />
							<div class="upload-logo">
								<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
									<input type="hidden" name="upload-type" value="login-screen-right" />
									<input type="file" name="upload" id="" />
									<button class="btn btn-success">Upload</button>


								</form>
							</div><!-- /.upload-logo -->
	          </div>
	      </section>
	      <section class="panel">
	          <header class="panel-heading">
	              Login Screen Bottom Ad
	          </header>
	          <div class="panel-body">

		          <div class="ad-show">
								<img src="{{ $site_url }}images/client-files/{{ $ad_login_bottom }}" class="img-responsive">
							</div><!-- /.ad-show -->

							<hr />

							<div class="upload-logo">
								<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
									<input type="hidden" name="upload-type" value="login-screen-bottom" />
									<input type="file" name="upload" id="" />
									<button class="btn btn-success">Upload</button>


								</form>
							</div><!-- /.upload-logo -->
	          </div>
	      </section>
	      <section class="panel">
	          <header class="panel-heading">
	              Scrolling Ads
	          </header>
	          <div class="panel-body">

							<div class="upload-logo">
								<form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
									<input type="hidden" name="upload-type" value="scroll-ads" />
									<input type="file" name="upload[]" id="" multiple />
									<button class="btn btn-success">Upload</button>

									<hr />
									<div class="row">
										@foreach($scroll_ads as $image)

										<div class="col-md-3">
											<img src="{{ $site_url }}images/client-files/{{ $image['image_name'] }}" alt="" class="img-responsive" />
											<p><a href="{{ $site_url }}admin-remove-ads.php?image={{ $image['id'] }}" class="btn btn-primary">Delete</a></p>
										</div><!-- /.col-md-3 -->
										@endforeach
									</div><!-- /.row -->


								</form>
							</div><!-- /.upload-logo -->
	          </div>
	      </section>
	  </div>
	</div>
@stop