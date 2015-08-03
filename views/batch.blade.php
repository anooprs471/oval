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
    <div class="wrapper1">
<?php $count = 0;
$total_count = 0;
$row = 0;
?>
    @if (count($coupons) > 0)


            @foreach ($coupons as $coupon)

                @if ($count == 0)
                    <div style="overflow: hidden;">
            @endif

                    <div style="width: 19%; float: left; margin: .5%">
                        <div style="border: 1px solid #E3E3E3; padding: 5px;">
                            <div style="overflow:hidden">
                                 <img src="{{$site_url}}/images/client-files/{{ $logo_file }}" style="width=100%">
                            </div>
                            <p>&nbsp;</p>
                            <p style="text-align: center ">
                                Username<br />
                                <span style="font-weight: bold">
                                {{ strtoupper($coupon['coupon']) }}
                                </span>
                            </p>
                            <p style="text-align: center">
                                Password<br />
                                <span style="font-weight: bold">{{ strtoupper($coupon['password']) }}</span>
                            </p>
                            <p style="text-align: center">
                                Plan<br />
                                <span style="font-weight: bold">{{ strtoupper($coupon['planname']) }}</span>
                            </p>
                            <p style="text-align: center">
                                Price<br />
                                Rs.
                                <span style="font-weight: bold">
                                {{ strtoupper($coupon['price']) }} /-
                                </span>
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

                @if ($row == 3)
                    <div style="padding-top:20px;">&nbsp;</div>
                    <?php $row = 0;?>
                @endif

            @endforeach
      @else
        {{-- false expr --}}
    @endif


    </div><!-- /.wrapper -->
</body>
</html>