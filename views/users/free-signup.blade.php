@extends('sign-up-layout')

@section('content')

	<div class="sign-up">

		<h2 class="form-signin-heading">sign in now</h2>

		<div class="form-wrap">
			<div class="sign-up-form">
				@if(!empty($errors))
					<div class="notification error">
						<ul>
						@foreach($errors as $error)
							<li>{{$error}}</li>
						@endforeach
						</ul>
					</div><!-- /.notification error -->
				@endif
				<form method="POST" action="">
					<input type="text" name="phone-number" autofocus="" placeholder="phone number" class="form-control" autocomplete="off" value="{{ $form_data['phone-number'] }}">

					<button type="submit" class="btn btn-lg btn-login btn-block">Sign Up</button>
				</form>
			</div><!-- /.sign-up-form -->



		</div><!-- /.sign-up-wrap -->



	</div><!-- /.sign-up -->

@stop