@extends('layout')

@section('content')
    <section id="cart_items">
        <div class="container">
            <div class="register-req ">
                <p>Please Fill Up The All Informations</p>
            </div><!--/register-req-->

            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="bill-to">
                            <p>Bill To</p>
                            <div class="form-one">
                                <form method="post" action="{{url('/save-shipping-details')}}">
                                    {{csrf_field()}}
                                    <input type="email" placeholder="Email*"        name="shipping_email" required="">
                                    <input type="text" placeholder="First Name *"   name="shipping_first_name" required="">
                                    <input type="text" placeholder="Last Name *"    name="shipping_last_name" required="">
                                    <input type="text" placeholder="Address *"      name="shipping_address" required="">
                                    <input type="text" placeholder="Mobile Number *" name="shipping_mobile_number" required="">
                                    <input type="text" placeholder="City *"         name="shipping_city" required="">
                                    <button type="submit" class="btn btn-default check_out">Done Shipping</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--<div class="payment-options">
					<span>
						<label><input type="checkbox"> Direct Bank Transfer</label>
					</span>
                <span>
						<label><input type="checkbox"> Check Payment</label>
					</span>
                <span>
						<label><input type="checkbox"> Paypal</label>
					</span>
            </div>--}}
        </div>
    </section> <!--/#cart_items-->
@endsection