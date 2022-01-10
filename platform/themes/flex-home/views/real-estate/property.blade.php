@php
    Theme::asset()->usePath()->add('leaflet-css', 'libraries/leaflet.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'libraries/leaflet.js');
    Theme::asset()->usePath()->add('magnific-css', 'libraries/magnific/magnific-popup.css');
    Theme::asset()->container('footer')->usePath()->add('magnific-js', 'libraries/magnific/jquery.magnific-popup.min.js');
    Theme::asset()->container('footer')->usePath()->add('property-js', 'js/property.js');
@endphp
<style type="text/css">
    #trafficMap{
        display: none;
    }
</style>
<main class="detailproject bg-white">
    <div data-property-id="{{ $property->id }}"></div>
    @include(Theme::getThemeNamespace() . '::views.real-estate.includes.slider', ['object' => $property])

    <div class="container-fluid w90 padtop20">
         <h1 class="titlehouse">{{ $property->name }}</h1> 

        <p class="addresshouse"><i class="fas fa-map-marker-alt"></i> {{ $property->city_name }}</p>
        <p class="pricehouse"> </p>
        <div class="row">
            <div class="col-md-8">
                <div class="row pt-3">
                    <div class="col-sm-12">
                        <h5 class="headifhouse">{{ __('Overview') }}</h5>
                        <div class="row py-2">
                            <div class="col-sm-12">
                                <table class="table table-striped table-bordered">
                                    @if ($property->category)
                                        <tr>
                                            <td scope="row">{{ __('Category') }}</td>
                                            <td><b>{{ $property->category_name }}</b></td>
                                        </tr>
                                    @endif
                                    @if ($property->square)
                                        <tr>
                                            <td scope="row">{{ __('Square') }}</td>
                                            <td><b>{{ $property->square_text }}</b></td>
                                        </tr>
                                    @endif
                                    @if ($property->number_bedroom)
                                        <tr>
                                            <td scope="row">{{ __('Number of bedrooms') }}</td>
                                            <td><b>{{ number_format($property->number_bedroom) }}</b></td>
                                        </tr>
                                    @endif
                                    @if ($property->number_bathroom)
                                        <tr>
                                            <td scope="row">{{ __('Number of bathrooms') }}</td>
                                            <td><b>{{ number_format($property->number_bathroom) }}</b></td>
                                        </tr>
                                    @endif
                                    @if ($property->number_floor)
                                        <tr>
                                            <td scope="row">{{ __('Number of floors') }}</td>
                                            <td><b>{{ number_format($property->number_floor) }}</b></td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td scope="row">{{ __('Price') }}</td>
                                        <td><b>{{ $property->price }}</b></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($property->content)
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="headifhouse">{{ __('Description') }}</h5>
                            {!! clean($property->content) !!}
                        </div>
                    </div>
                @endif
                @if ($property->features->count())
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="headifhouse">{{ __('Features') }}</h5>
                            <div class="row">
                                @foreach($property->features as $feature)
                                    <div class="col-sm-4">
                                        <p><i class="@if ($feature->icon) {{ $feature->icon }} @else fas fa-check @endif text-orange text0i"></i>  {{ $feature->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                <br>
                @if ($property->facilities->count())
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="headifhouse">{{ __('Distance key between facilities') }}</h5>
                            <div class="row">
                                @foreach($property->facilities as $facility)
                                    <div class="col-sm-4">
                                        <p><i class="@if ($facility->icon) {{ $facility->icon }} @else fas fa-check @endif text-orange text0i"></i>  {{ $facility->name }} - {{ $facility->pivot->distance }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
                @if ($property->project_id && $project = $property->project)
                    <div class="row pb-3">
                        <div class="col-sm-12">
                            <h5 class="headifhouse">{{ __('Project\'s information') }}</h5>
                        </div>
                        <div class="col-sm-12">
                            <div class="row item">
                                <div class="col-md-4 col-sm-5 pr-sm-0">
                                    <div class="img h-100 bg-light">
                                        <a href="{{ $project->url }}">
                                            <img class="thumb lazy"
                                                data-src="{{ RvMedia::getImageUrl($project->image, null, false, RvMedia::getDefaultImage()) }}"
                                                src="{{ RvMedia::getImageUrl($project->image, null, false, RvMedia::getDefaultImage()) }}"
                                                alt="{{ $project->name }}">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-8 col-sm-7 pt-2 pr-sm-0 bg-light">
                                    <h5><a href="{{ $project->url }}" class="font-weight-bold text-dark">{{ $project->name }}</a></h5>
                                    <div>{{ Str::limit($project->description, 120) }}</div>
                                    <p><a href="{{ $project->url }}">{{ __('Read more') }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <br>
                
                @if ($property->latitude && $property->longitude)
                    {!! Theme::partial('real-estate.elements.traffic-map-modal', ['location' => $property->location . ', ' . $property->city_name]) !!}
                    <div id="embedMap" style="display: none;">
                        <!--Google map will be embedded here-->
                    </div>
                    <div id="googleMap" style="width:100%;height:380px;"></div>
                @else
                    {!! Theme::partial('real-estate.elements.gmap-canvas', ['location' => $property->location]) !!}
                @endif
                @if ($property->video_url)
                    {!! Theme::partial('real-estate.elements.video', ['object' => $property, 'title' => __('Property video')]) !!}
                @endif
                <br>
                {!! Theme::partial('share', ['title' => __('Share this property'), 'description' => $property->description]) !!}
                <div class="clearfix"></div>
                <div id="mapCanvas" style="width: 100%;height: 500px;"></div>

                
            </div>
            <div class="col-md-4">
                @if ($author = $property->author)
                    <div class="boxright p-3" style="display: none;">
                        <div class="head">
                            {{ __('Contact agency') }}
                        </div>

                        <div class="row rowm10 itemagent">
                            <div class="col-lg-4 colm10">
                                @if ($author->username)
                                    <a href="{{ route('public.agent', $author->username) }}">
                                        @if ($author->avatar->url)
                                            <img src="{{ RvMedia::getImageUrl($author->avatar->url, 'thumb') }}" alt="{{ $author->name }}" class="img-thumbnail">
                                        @else
                                            <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}" class="img-thumbnail">
                                        @endif
                                    </a>
                                @else
                                    @if ($author->avatar->url)
                                        <img src="{{ RvMedia::getImageUrl($author->avatar->url, 'thumb') }}" alt="{{ $author->name }}" class="img-thumbnail">
                                    @else
                                        <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}" class="img-thumbnail">
                                    @endif
                                @endif
                            </div>
                            <div class="col-lg-8 colm10">
                                <div class="info">
                                    <p>
                                        <strong>
                                            @if ($author->username)
                                                <a href="{{ route('public.agent', $author->username) }}">{{ $author->name }}</a>
                                            @else
                                                {{ $author->name }}
                                            @endif
                                        </strong>
                                    </p>
                                    <p class="mobile">{{ $author->phone }}</p>
                                    <p>{{ $author->email }}</p>
                                    @if ($author->username)
                                        <p><span class="fas fa-arrow-circle-right"></span> <a href="{{ route('public.agent', $author->username) }}">{{ __('More properties by this agent') }}</a></p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(Session::has('msg'))
                    <div class="col-md-12">
                        <p class="text-success">{{Session::get('msg')}}</p>
                    </div>
                @endif
                @if($errors->any())
                    <div class="col-md-12">
                        <p class="text-danger">Invalid Coupon</p>
                    </div>
                @endif

                @if($property->cat_type != 'FLAT MATE')
                    @if (auth('account')->check())
                        <form action="{{url('/admin/couponApply')}}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" placeholder="Enter Coupon Code" {{(Session::has('discountCoupon'))?'disabled':''}} name="couponText" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="submit"  class="btn btn-info" <?=(Session::has('discountCoupon'))?'disabled':''?> value="Apply">
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                @endif

                
                <?php
                    
                    $discount = 0;
                    $total = 0;
                    $gst = 0;
                    $deposit = 0;
                    $gstCalculate = 0;

                    $sqlSecurit = DB::table('pay-description')->first();
                    if(isset($sqlSecurit)){
                        $gst = $sqlSecurit->gst;
                        $deposit = $sqlSecurit->security_deposit;
                        $gstCalculate = ($property->price * $gst) / 100;
                    }

                     
                     if(Session::has('discountCoupon')){
                        $discount = (Session::get('discountCoupon') * $property->price) / 100;
                     }



                    

                ?>
                
                

                @if($property->cat_type != 'FLAT MATE' && $property->type == 'rent')
                    @if (auth('account')->check())
                    <?php
                        $sqlUser = DB::table('re_accounts')->where('id' , auth('account')->user()->id)->first();
                    ?>

                        @if($sqlUser->address !='' && $sqlUser->adhaarNo !='' && $sqlUser->adhaarImage !='' && $sqlUser->signatureImage !='' && $sqlUser->avatar_id !='')
                            @if($sqlUser->addressApprove == 'yes')
                            <form action="{{route('rent.payment')}}" method="POST">
                                @csrf 
                                <input type = "hidden" name="property_id" value="{{$property->id}}"> 
                                
                                
                            <?php

                            $sqlCheck = DB::table('re_accounts')->where('id' , auth('account')->user()->id)->first();
                            $date = date('Y-m-d');
                            //$date = '2022-01-25';
                            if($sqlCheck->rent){
                                $book_now = DB::table('rental_details')->where('id',$sqlCheck->rent)->where('status' , 'A')->first();
                                if(isset($book_now)){
                                        $total = ($property->price + $gstCalculate) - $discount;

                                    ?>
                                        <div class="boxrght p-3" style="">
                                            <div class="head">
                                                <input type = "hidden" name="price" value="{{round($total)}}">
                                                <button type="submit" class="btn btn-success">Pay Rent</button>
                                            </div>
                                        </div>

                                        <div class="boxrght p-3" style="">
                                            <div class="head">
                                                <p>GST : {{$gstCalculate}}</p>
                                                <p>Discount : {{$discount}}</p>
                                                <p>Total : {{round($total)}}</p>
                                            </div>
                                        </div>
                                    <?php
                                }else{
                                    $laterPayment = DB::table('rental_details')->where('id',$sqlCheck->rent)->where('status' , 'P')->first();
                                    if(isset($laterPayment)){
                                        $modifyDate = date('Y-m-d',strtotime($laterPayment->created_at));
                                        $oneMonthCalculate = date('Y-m-d', strtotime('+1 month', strtotime($modifyDate)));
                                        $afterFiveDays = date('Y-m-d', strtotime('+5 day', strtotime($oneMonthCalculate)));

                                        if($date > $afterFiveDays){
                                            $days = (strtotime($date) - strtotime($afterFiveDays)) / (60 * 60 * 24);
                                            $betweenTwoDates = $days;
                                            $calculateAmount = (200 * $betweenTwoDates) + $property->price;

                                            $total = ($calculateAmount + $gstCalculate) - $discount;
                                            ?>
                                                <div class="boxrght p-3" style="">
                                                    <div class="head">
                                                        <small>Extra Charge : per day 200 Rs included</small>
                                                    </div>
                                                </div>


                                                <div class="boxrght p-3" style="">
                                                    <div class="head">
                                                        <p>GST : {{$gstCalculate}}</p>
                                                        <p>Discount : {{$discount}}</p>
                                                        <p>Total : {{round($total)}}</p>
                                                    </div>
                                                </div>

                                                <input type = "hidden" name="price" value="{{round($total)}}">
                                            <?php
                                        }else{
                                            $total = ($property->price + $gstCalculate) - $discount;
                                            ?>
                                                <div class="boxrght p-3" style="">
                                                    <div class="head">
                                                        <p>GST : {{$gstCalculate}}</p>
                                                        <p>Discount : {{$discount}}</p>
                                                        <p>Total : {{round($total)}}</p>
                                                    </div>
                                                </div>

                                                <input type = "hidden" name="price" value="{{round($total)}}">
                                            <?php
                                        }
                                    }else{
                                        $total = ($property->price + $gstCalculate) - $discount;
                                        ?>

                                            <div class="boxrght p-3" style="">
                                                <div class="head">
                                                    <p>GST : {{$gstCalculate}}</p>
                                                    <p>Discount : {{$discount}}</p>
                                                    <p>Total : {{round($total)}}</p>
                                                </div>
                                            </div>
                                            <input type = "hidden" name="price" value="{{round($total)}}">
                                        <?php
                                    }
                                    ?>
                                        <div class="boxrght p-3" style="">
                                            <div class="head">
                                                
                                                <button type="submit" class="btn btn-success">Pay Rent</button>
                                            </div>
                                        </div>

                                        <div class="boxrght p-3" style="">
                                            <div class="head">
                                                <p>GST : {{$gstCalculate}}</p>
                                                <p>Discount : {{$discount}}</p>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }else{
                                $detalCheck = DB::table('rental_details')->where('property_id',$property->id)->count();
                                if($detalCheck == 0){
                                    

                                   $total = ($property->price + $deposit + $gstCalculate) - $discount;

                                ?>
                                    <div class="boxrght p-3" style="">
                                        <div class="head">
                                            <input type = "hidden" name="price" value="{{round($total)}}">
                                            <button type="submit" class="btn btn-success">Book Now</button>
                                        </div>
                                    </div>

                                    <div class="boxrght p-3" style="">
                                        <div class="head">
                                            <p>GST : {{$gstCalculate}}</p>
                                            <p>Security Deposit : {{$deposit}}</p>
                                            <p>Discount : {{$discount}}</p>
                                            <p>Total : {{round($total)}}</p>
                                        </div>
                                    </div>
                                <?php
                                }else{
                                    ?> 
                                        <div class="boxrght p-3" style="">
                                            <div class="head">
                                                
                                                <button type="button" class="btn btn-secondary">Occupied</button>
                                            </div>
                                        </div>
                                    <?php
                                }
                            }

                            ?>
                            
                            </form>
                            @else
                            <div class="boxrght p-3" style="">
                                <div class="head">
                                    <p><a href="{{url('activetionKyc/'.auth('account')->user()->id.'/'.$property->author_id)}}" class="btn btn-secondary">Booking activation</a></p>
                                </div>
                            </div>
                            @endif
                        @else

                            <div class="boxrght p-3" style="">
                                <div class="head">
                                    <p>Please fill your kyc <a href="{{url('account/settings')}}">Click Here</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="boxrght p-3" style="">
                            <div class="head">
                                <button type="submit" class="btn btn-success" onclick="window.location.href='<?=url('/login')?>'">Book Now</button>
                            </div>
                        </div>
                    @endif

                @endif
                 
                @if($property->cat_type != 'FLAT MATE')
                    @if (auth('account')->check())
                    <?php
                        $sqlCheck1 = DB::table('re_accounts')->where('id' , auth('account')->user()->id)->first();
                        $detalCheck1 = DB::table('rental_details')->where('id',$sqlCheck1->rent)->count();
                        if($detalCheck1 > 0){
                    ?>
                    <div class="boxright p-3" style="">
                            <div class="head">
                                {{ __('Submit your Review')}}
                            </div>
                            <form method="POST" action="{{route('feedback')}}">
                                        {{ csrf_field() }}
                                        <input type = "hidden" name="property_id" value="{{$property->id}}">
                                        <div class="form-group">
                                        <label for="exampleInputEmail1"><b>NAME</b></label>
                                        <input type="text" id="title" name="name" class="form-control" placeholder="name" required="">
                                        </div>
                                        <div class="form-group">
                                        <label for="exampleInputEmail1"><b>EMAIL</b></label>
                                        <input type="text" id="title" name="email" class="form-control" placeholder="email" required="">
                                        </div>
                                        <div class="form-group">
                                        <label for="exampleInputEmail1"><b>PHONE</b></label>
                                        <input type="text" id="title" name="phone" class="form-control" placeholder="phone" required="">
                                        </div>
                                        <div class="form-group">
                                        <label for="exampleInputEmail1"><b>TESTIMONIAL</b></label>
                                        <input type="text" id="title" name="message" class="form-control" placeholder="message" required="">
                                        </div>
                                        <div class=form>
                                   <button type="submit" class="btn btn-primary">SEND</button>
                                 </div>
                                    </form>
                        </div>
                        <?php
                            }
                        ?>
                        @endif
                    @endif



                    <div class="boxright p-3" style="display:block">
                        <div class="head">
                            {{ __('Report what was not correct in this property') }}
                        </div>
                        <form method="POST" action="{{route('feedback')}}">
                            {{ csrf_field() }}
                            <?php
                                $replaceName = str_replace(' ','-',$property->name);
                                
                            ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?=url('property-report/Listed-by-broke/'.$replaceName)?>'" name="" value="Listed by broker">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?=url('property-report/Rented-out/'.$replaceName)?>'" name="" value="Rented out">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?=url('property-report/Wrong-info/'.$replaceName)?>'" name="" value="Wrong info">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                <div class="boxright p-3">
                    {!! Theme::partial('consult-form', ['type' => 'property', 'data' => $property]) !!}
                </div>
            </div>
        </div>
        <br>
        <h5 class="headifhouse">{{ __('Related properties') }}</h5>
        <div class="projecthome mb-3">
            <property-component type="related" url="{{ route('public.ajax.properties') }}" :property_id="{{ $property->id }}"></property-component>
        </div>
        <div class="headifhouse">
            @php
            $review = DB::table('feedback')->select('message','name')->where('property_id',$property->id)->get();
            @endphp
            <h5><b>Reviews</b></h5>
            @foreach($review as $valuess)
            <img src="{{asset('storage/user_image.png')}}" width="40" height="40">
            <p><b>{{$valuess->name}}</b>:<?= $valuess->message ?></p>
            @endforeach
        </div>
        
    </div>
</main>

<script id="traffic-popup-map-template" type="text/x-custom-template">
    {!! Theme::partial('real-estate.properties.map', ['property' => $property]) !!}
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxYNofOwLqa8Vm59-a9XyRoTQ-pUCPC1U"></script>
<?php
    $data[0]['lat'] = $property->latitude;
    $data[0]['long'] = $property->longitude;
    
?>
<script>
    

function initialize()
{
    <?php for($i=0;$i<count($data);$i++){?>
        
var myCenter=new google.maps.LatLng(<?php echo $data[$i]['lat'].','.$data[$i]['long']; ?>);
console.log(myCenter);
var mapProp = {
  center:myCenter,
  zoom:12,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker=new google.maps.Marker({
  position:myCenter,
  map: map,
    animation: google.maps.Animation.DROP
  });

marker.setMap(map);

<?php }?>

}

google.maps.event.addDomListener(window, 'load', initialize);





</script>
