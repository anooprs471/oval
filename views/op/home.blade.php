@extends('layout')

@section('content')
	<div class="row">
	  <div class="col-md-12">
	  		@if($msg != '')
          <div class="alert alert-danger">{{$msg}}</div>
          <p></p>
        @endif
        @if($flash != '')
          <div class="alert alert-success ">{{$flash}}</div>
          <p></p>
        @endif
	      <section class="panel">
	          <div class="panel-body profile-information">
	             <div class="col-md-3">
	                 <div class="profile-pic text-center">
	                     <img src="images/lock_thumb.jpg" alt=""/>
	                 </div>
	             </div>
	             <div class="col-md-6">
	                 <div class="profile-desk">
	                     <h1>Welcome {{$name}}</h1>
	                     <span class="text-muted">Sales</span>
	                     <p>
	                         Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean porttitor vestibulum imperdiet. Ut auctor accumsan erat, a vulputate metus tristique non. Aliquam aliquam vel orci quis sagittis.
	                     </p>

	                 </div>
	             </div>
	             <div class="col-md-3">
	                 <div class="profile-statistics">
	                     <h1>1240</h1>
	                     <p>Total Coupons</p>
	                     <h1>10</h1>
	                     <p>This Week</p>

	                 </div>
	             </div>
	          </div>
	      </section>
	  </div>
	  <div class="col-md-12">
	      <section class="panel">
	          <header class="panel-heading tab-bg-dark-navy-blue">
	              <ul class="nav nav-tabs nav-justified ">
			              <li class="active">
	                      <a data-toggle="tab" href="#search-patient">
	                          Customer
	                      </a>
	                  </li>
	                  <li>
	                      <a data-toggle="tab" href="#contacts">
	                          Contacts
	                      </a>
	                  </li>

	                  <li>
	                      <a data-toggle="tab" href="#settings">
	                          User Settings
	                      </a>
	                  </li>
	              </ul>
	          </header>
	          <div class="panel-body">
	              <div class="tab-content tasi-tab">

										<div id="search-patient" class="tab-pane active">
	                      <div class="row">
	                          <div class="col-md-6">
	                              <div class="prf-contacts">
	                                  <h2>Find</h2>
	                                  <form class="form-horizontal" role="form" method="GET" action="op-coupon-stats.php">
	                                  	<div class="form-group">
					                                <label class="col-lg-4 col-sm-2 control-label">Coupon Username</label>
					                                <div class="col-lg-8">
					                                    <input type="text" class="form-control" name="coupon-username" value="" placeholder="username">
					                                </div>
					                            </div>
	                                  </form>
	                              </div>
	                          </div>
	                          <div class="col-md-6">
	                              <div class="prf-contacts">
	                                  <h2>Add User</h2>
	                              </div>
		                             <div class="add-patient-wrap">
			                             <section class="panel">
	   							                    <header class="panel-heading">
	   							                        User Details
	   							                    </header>
	   							                    @if(!empty($err))
															          <div class="alert alert-danger">
															          	@foreach($err as $error)
															          		{{$error}}<br />
															          	@endforeach
															          </div>
															          <p></p>
															        @endif
	   							                    <div class="panel-body">
	   							                        <div class="position-center1">
	   							                            <form class="form-horizontal" role="form" method="POST" action="" enctype="multipart/form-data">
	   							                            <input type="hidden" name="form-type" value = "create-customer" />
	   							                            <div class="form-group">
	   							                                <label for="patient-id" class="col-lg-4 col-sm-2 control-label">Patient ID</label>
	   							                                <div class="col-lg-8">
	   							                                    <input type="text" class="form-control" name="patient-id" value="{{$form['patient_id']}}">
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
													                                <option value="Driving License">Driving License</option>
													                                <option value="Voters ID">Voters ID</option>
													                                <option value="Ration Card">Ration Card</option>

													                            </select>
	   							                                    <p class="help-block">Document presented as ID proof</p>
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
	   							                        </form>
	   							                        </div>
	   							                    </div>
	   							                </section>
   							                </div>
	                          </div>

	                      </div>
	                  </div>
	                  <div id="contacts" class="tab-pane">
	                      <div class="row">
	                          <div class="col-md-6">
	                              <div class="prf-contacts">
	                                  <h2> <span><i class="fa fa-map-marker"></i></span> location</h2>
	                                  <div class="location-info">
	                                      <p>Postal Address<br>
	                                          PO Box 16122 Collins Street West<br>
	                                          Victoria 8007 Australia</p>
	                                      <p>Headquarters<br>
	                                          121 King Street, Melbourne<br>
	                                          Victoria 3000 Australia</p>
	                                  </div>
	                                  <h2> <span><i class="fa fa-phone"></i></span> contacts</h2>
	                                  <div class="location-info">
	                                      <p>Phone	: +61 3 8376 6284 <br>
	                                          Cell		: +61 3 8376 6284</p>
	                                      <p>Email		: david@themebucket.net<br>
	                                          Skype		: david.rojormillan</p>
	                                      <p>
	                                          Facebook	: https://www.facebook.com/themebuckets <br>
	                                          Twitter	: https://twitter.com/theme_bucket
	                                      </p>
	                                  </div>
	                              </div>
	                          </div>

	                      </div>
	                  </div>
	                  <div id="settings" class="tab-pane ">
	                      <div class="position-center">
	                          <div class="prf-contacts sttng">
	                              <h2>  Personal Information</h2>
	                          </div>
	                          <form role="form" class="form-horizontal" method="POST" action="">
	                              <input type="hidden" name="form-type" value="personel" />
	                              <div class="form-group">
	                                  <label class="col-lg-2 control-label"> First Name</label>
	                                  <div class="col-lg-6">
	                                      <input type="text" placeholder="First Name" id="first-name" name="first-name" class="form-control" value="{{$first_name}}">
	                                  </div>
	                              </div>
	                              <div class="form-group">
	                                  <label class="col-lg-2 control-label"> Last Name</label>
	                                  <div class="col-lg-6">
	                                      <input type="text" placeholder="Last Name" id="last-name" name="last-name" class="form-control" value="{{$last_name}}">
	                                  </div>
	                              </div>
	                              <div class="form-group">
	                                  <div class="col-lg-offset-2 col-lg-10">
	                                      <button class="btn btn-primary" type="submit">Save</button>
	                                      <button class="btn btn-default" type="button">Cancel</button>
	                                  </div>
	                              </div>

	                          </form>

	                          <form role="form" class="form-horizontal" method="POST" action="">
	                              <input type="hidden" name="form-type" value="password" />
	                              <div class="prf-contacts sttng">
			                              <h2>  Account Password</h2>
			                          </div>
	                              <div class="form-group">
	                                  <label class="col-lg-2 control-label"> Old Password</label>
	                                  <div class="col-lg-6">
	                                      <input type="text" placeholder=" " id="old-password" name="old-password" class="form-control">
	                                  </div>
	                              </div>
	                              <div class="form-group">
	                                  <label class="col-lg-2 control-label"> New Password</label>
	                                  <div class="col-lg-6">
	                                      <input type="text" placeholder=" " id="new-password" name="new-password" class="form-control">
	                                  </div>
	                              </div>
	                              <div class="form-group">
                                    <div class="col-lg-offset-2 col-lg-10">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                        <button class="btn btn-default" type="button">Cancel</button>
                                    </div>
                                </div>
	                          </form>


	                      </div>

	                  </div>
	              </div>
	          </div>
	      </section>
	  </div>
	</div>
@stop