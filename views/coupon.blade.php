<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$page_title}}</title>
    <!--Core CSS
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/pdf.css" rel="stylesheet">-->


</head>
<body>
    <div class="wrapper">
        <div class="row">

            <div class="coupon-header">
                <div class="invoice-header">
                    <div class="invoice-title">
                        <h1>Coupon</h1>
                        <div class="logo">
                            <img src="{{$site_url}}/images/client-files/{{ $logo_file }}">
                        </div><!-- /.logo -->
                    </div>
                </div>
            </div><!-- /.coupon-header -->


            <div class="coupon-data">
                <table class="table table-invoice">

                    <tbody>
                        <tr>
                            <td class="title">Username</td>
                            <td class="value"><strong>{{strtoupper( $coupon_details['username'] )}}</strong></td>
                        </tr>
                        <tr>
                            <td class="title">Password</td>
                            <td class="value"><strong>{{strtoupper( $coupon_details['password'] )}}</strong></td>
                        </tr>
                        <tr>
                            <td class="title">Plan</td>
                            <td class="value">{{$coupon_details['plan_name']}}</td>
                        </tr>
                        <tr>
                            <td class="title">Price</td>
                            <td class="value">Rs. {{$coupon_details['price']}} /-</td>
                        </tr>
                        <tr>
                            <td class="title">Date</td>
                            <td class="value">{{$coupon_details['coupon_date']}}</td>
                        </tr>
                        <tr>
                            <td class="title">Valid Till</td>
                            <td class="value">{{$coupon_details['expiration']}}</td>
                        </tr>


                    </tbody>
                </table>
            </div><!-- /.coupon-data -->



        </div><!-- /.row -->
        <hr />
        <p>
            * <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</small>
        </p>
    </div><!-- /.wrapper -->
</body>
</html>