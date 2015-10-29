<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$page_title}}</title>
    <!--Core CSS-->
    <link href="bs3/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/pdf-batch.css" rel="stylesheet">


</head>
<body>
    <div class="wrapper1">
<?php $count = 0;
$total_count = 0;
$row = 0;
?>
    @if (count($coupons) > 0)


            @foreach ($coupons as $coupon)

                @if ($count == 0)
                    <div class="coupons-wrap">
            @endif

                    <div class="coupon">
                        <div class="coupon-inner">
                            <p style="text-align: left">
                                [ <span>{{ strtoupper($coupon['batch_serial_number']) }}</span> ]
                            </p>
                            <p>
                                {{ strtoupper($coupon['batch_name']) }}
                            </p>
                            <div class="coupon-logo">
                                 <img src="{{$site_url}}/images/client-files/{{ $logo_file }}">
                            </div>
                            <p>
                                User id : <span>{{ strtoupper($coupon['coupon']) }}</span>
                            </p>
                            <p>
                                Pass : <span>{{ strtoupper($coupon['password']) }}</span>
                            </p>
                            <p>
                                Plan<br />

                                {{ strtoupper($coupon['planname']) }}

                            </p>
                            <p>
                                Price : Rs. <span>{{ strtoupper($coupon['price']) }}</span> /-

                            </p>
                        </div>
                    </div>
<?php $count++;
$total_count++;?>
                @if ($count == $cols || $total_count == count($coupons))
                    <!--{{$count}}-->
                    </div>
<?php $count = 0;
$row++;?>
                @endif

                @if ($row == 5)
                    <div class="spacer">&nbsp; -|-</div>
                    <?php $row = 0;?>
                @endif

            @endforeach
      @else
        {{-- false expr --}}
    @endif


    </div><!-- /.wrapper -->
</body>
</html>