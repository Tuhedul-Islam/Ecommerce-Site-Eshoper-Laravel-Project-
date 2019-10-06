@extends('layout')
@section('content')

    <style type=text/css>
        .payment input{
            margin:0;padding:0;
            -webkit-appearance:none;
            -moz-appearance:none;
            appearance:none;
        }
        .handcash{background-image:url('paymentImg/handCash.png');}
        .paypal{background-image:url('paymentImg/paypal.png');}
        .bkash{background-image:url('paymentImg/bCash.png');}
        .mastercard{background-image:url('paymentImg/masterCard.png');}

        .payment input:active +.card{opacity: .9;}
        .payment input:checked +.card{
            -webkit-filter: none;
            -moz-filter: none;
            filter: none;
        }
        .card{
            cursor:pointer;
            background-size:contain;
            background-repeat:no-repeat;
            display:inline-block;
            width:100px;height:70px;
            -webkit-transition: all 100ms ease-in;
            -moz-transition: all 100ms ease-in;
            transition: all 100ms ease-in;
            -webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
            -moz-filter: brightness(1.8) grayscale(1) opacity(.7);
            filter: brightness(1.8) grayscale(1) opacity(.7);
        }
        .card:hover{
            -webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
            -moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
            filter: brightness(1.2) grayscale(.5) opacity(.9);
        }

        /* Extras */
        a:visited{color:#888}
        a{color:#444;text-decoration:none;}
        p{margin-bottom:.3em;}
    </style>

    <section id="cart_items">
        <div class="container col-sm-12">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="table-responsive cart_info">
                <?php
                //use Gloudemans\Shoppingcart\Facades\Cart;
                $contents = Cart::content();

                /*echo "<pre>";
                print_r($contents);
                echo "</pre>";
                exit();*/
                ?>
                <table class="table table-condensed">
                    <thead>
                    <tr class="cart_menu">
                        <td class="image">Image</td>
                        <td class="description">Name</td>
                        <td class="price">Price</td>
                        <td class="quantity">Quantity</td>
                        <td class="total">Total</td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($contents as $content)
                        <tr>
                            <td class="cart_product">
                                <a href=""><img src="{{URL::to($content->options->image)}}" height="80px" width="80px" alt=""></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href="">{{$content->name}}</a></h4>
                            </td>
                            <td class="cart_price">
                                <p>{{$content->price}} Tk</p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <form action="{{url('/update-cart-item')}}" method="post">
                                        {{csrf_field()}}
                                        <input class="cart_quantity_input" type="text" name="qty" value="{{$content->qty}}" autocomplete="off" size="2">
                                        <input class="" type="hidden" name="rowId" value="{{$content->rowId}}">
                                        <input type="submit" name="submit" value="Update" class="btn btn-sm btn-default">
                                    </form>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">{{$content->total}} Tk</p>
                            </td>
                            <td class="cart_delete">
                                <a class="cart_quantity_delete" href="{{URL::to('/delete-cart-item/'.$content->rowId)}}"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section> <!--/#cart_items-->
    <section id="do_action">
        <div class="container col-sm-8">
            {{--<div class="heading">
                <h3>What would you like to do next?</h3>
                <p>Choose if you have a discount code or reward points you want to use or would like to estimate your delivery cost.</p>
            </div>--}}
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Payment method</li>
                </ol>
            </div>
            <div class="paymentCont col-sm-12">
                <div class="headingWrap">
                    <h3 class="headingTop text-center">Select Your Payment Method</h3>
                    <p class="text-center text-danger"><b>Click one of the bellow options</b></p>
                </div>
                <div class="">
                    <form method="post" action="{{url('/order-place')}}">
                        {{csrf_field()}}
                        <div class="payment">
                            <input id="handcash" type="radio" name="payment_method" value="handcash" checked />
                            <label class="card handcash" for="handcash"></label>

                            <input id="paypal" type="radio" name="payment_method" value="paypal" />
                            <label class="card paypal" for="paypal"></label>

                            <input id="bkash" type="radio" name="payment_method" value="bkash" />
                            <label class="card bkash" for="bkash"></label>

                            <input id="mastercard" type="radio" name="payment_method" value="mastercard" />
                            <label class="card mastercard" for="mastercard"></label>
                        </div>
                        <div class="footerNavWrap clearfix">
                            <input type="submit" value="Done" name="submit" class="btn btn-warning">
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section><!--/#do_action-->
@endsection