@extends('layout')

@section('content')

<div class="col-md-8">

<section class="panel">
		<header class="panel-heading">
				Batch Issue

		</header>
		<div class="panel-body">
		@if(!empty($errors))
      <div class="alert alert-danger">
      <ul>

      @foreach ($errors as $err)
      	<li>{{$err}}</li>
      @endforeach
      </ul>
      </div>
      <p></p>
    @endif
		@if($msg != '')
      <div class="alert alert-danger">{{$msg}}</div>
      <p></p>
    @endif
    @if($flash != '')
      <div class="alert alert-success ">{{$flash}}</div>
      <p></p>
    @endif

		<div class="panel-body">
			<form action="" method="POST" role="form" class="form-horizontal" enctype="multipart/form-data">
				<input type="hidden" name="form-stage" value="{{$form_stage}}" />
				<input type="hidden" name="planname" value="{{$form['planname']}}" />

				@if ($form_stage == 1)

					<div class="form-group">
	            <label class="col-lg-4 col-sm-2 control-label" for="username">Coupon Username</label>
	            <div class="col-lg-8">
	                <input type="text" value="" name="username" class="form-control">
	            </div>

	        </div>
	        <div class="form-group">
            <div class="col-lg-offset-4 col-lg-8">
                <button class="btn btn-danger" type="submit">Find ID</button>
            </div>
	        </div>

        @endif

        @if ($form_stage == 2)
				<input type="hidden" name="username" value="{{$form['username']}}" />
				<input type="hidden" name="password" value="{{$form['password']}}" />


        	<div class="form-group">
				      <label for="name" class="col-lg-4 col-sm-2 control-label">Coupon</label>
				      <div class="col-lg-8">
				         <label for="name" class="col-lg-2 control-label"><strong>{{$form['username']}}</strong></label>
				      </div>
				  </div>

				  <div class="form-group">
				      <label for="name" class="col-lg-4 col-sm-2 control-label">Name</label>
				      <div class="col-lg-8">
				          <input type="text" class="form-control" name="customer-name" value="{{$form['customer_name']}}">
				      </div>
				  </div>
				  <div class="form-group">
				      <label for="mobile-number" class="col-lg-4 col-sm-2 control-label">Mobile Number</label>
				      <div class="col-lg-8">
				          <input type="text" class="form-control" name="mobile-number" value="{{$form['mobile_number']}}">
				      </div>
				  </div>
				  <div class="form-group">
				      <label for="mobile-number" class="col-lg-4 col-sm-2 control-label">ID Proof Number</label>
				      <div class="col-lg-8">
				          <input type="text" class="form-control" name="id-proof-number" value="{{$form['id_proof_number']}}">
				          <p class="help-block">As given in the ID proof</p>
				      </div>

				  </div>
				  <div class="form-group">
			      <label for="mobile-number" class="col-lg-4 col-sm-2 control-label">ID Proof Document Type</label>
			      <div class="col-lg-8">
			          <select class="form-control m-bot15" name="id-proof-type">
			            <option value="Voter identity card">Voter identity card</option>

			            <option value="Passport">Passport</option>

			            <option value="PAN Card">PAN Card</option>

			            <option value="Driving Licence">Driving Licence</option>

			            <option value="Aadhaar Unique Identification Card">Aadhaar Unique Identification Card</option>

			            <option value="Others">Others</option>

			        </select>
			          <p class="help-block">Document presented as ID proof <br />
			          <p></p>
			          <input type="text" name="other-id-proof"  class="form-control" />
			          <p>If selected other fill above</p>

			          </p>
			      </div>

				  </div>

				  <div class="form-group">
				    <label for="" class="col-lg-4 col-sm-2 control-label">Upload ID Document</label>
				    <div class="col-lg-8">
				      <input type="file" id="exampleInputFile" name="id-proof">
				      <p class="help-block">Scanned document of ID proof</p>
				    </div>
				</div>

			  <div class="form-group">
			      <div class="col-lg-offset-2 col-lg-10">
			          <button type="submit" class="btn btn-danger">Register Customer</button>
			      </div>
			  </div>
      @endif


			</form>
		</div>

		</div><!-- /.panel-body -->
</section><!-- /.panel -->
</div><!-- /.col-md-8 -->


@stop