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
$total_count = 0;?>
    @if (count($coupons) > 0)


            @foreach ($coupons as $coupon)
                @if ($count == 0)
                    <div style="overflow: hidden;">
            @endif

                    <div style="width: 19%; float: left; margin: .5%">
                        <div style="border: 1px solid #E3E3E3; padding: 5px;">
                            <p>Logo</p>
                            <p>Username : {{ strtoupper($coupon['coupon']) }}</p>
                            <p>Password : {{ strtoupper($coupon['password']) }}</p>
                            <p>Plan : {{ strtoupper($coupon['planname']) }}</p>
                            <p>Price : {{ strtoupper($coupon['price']) }}</p>
                        </div>
                    </div>
<?php $count++;
$total_count++?>
                @if ($count == $cols || $total_count == count($coupons))
                    <!--{{$count}}-->
                    </div>
                    <?php $count = 0;?>
                @endif

            @endforeach
      @else
        {{-- false expr --}}
    @endif

        <hr />
        <p>
            * <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua.</small>
        </p>
    </div><!-- /.wrapper -->
</body>
</html>