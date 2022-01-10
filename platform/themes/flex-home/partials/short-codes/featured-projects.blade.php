@php
    use Botble\Base\Enums\BaseStatusEnum;
    use Botble\RealEstate\Enums\ProjectStatusEnum;
    use Botble\RealEstate\Repositories\Interfaces\ProjectInterface;
    use Botble\Location\Repositories\Interfaces\CityInterface;

    $projects = collect([]);

    if (is_plugin_active('real-estate')) {
        $projects = app(ProjectInterface::class)->advancedGet([
            'condition' => [
                're_projects.is_featured' => true,
                ['re_projects.status', 'NOT_IN', [ProjectStatusEnum::NOT_AVAILABLE]],
            ],
            'take'      => (int)theme_option('number_of_featured_projects', 4),
            'with'      => config('plugins.real-estate.real-estate.projects.relations'),
        ]);
     }


     
@endphp

<style>
    .section-design{
        width: 100%;
        border: 2px solid #1d5f6f;
        padding: 10px;
        text-decoration: none;
        color: black;
    }
    .owl-carousel {
        display: block !important; 
        width: 150px !important;
    }
</style>
<div class="box_shadow" style="margin-top: 0;">
    <div class="container-fluid w90">
        <div class="projecthome">
            <h2>Services We Offer</h2>
            <div class="row rowm10">
              @php
              $icon = DB::table('maintenance')->get();
              @endphp
                @foreach ($icon as $keyicon => $value)
                    <div class="col-2 col-sm-2  col-md-2 colm10 text-center">
                        <a href="javascript:void(0)" class="text-center" style="text-decoration: none;color: #1D5F6F;">
                            <p>
                                <img src="{{asset($value->icon)}}">
                            </p>
                            <p style="font-weight:600;"><a href="{{url('services/'.$value->slug)}}" target="_blank"  style="color:#000;" >{{$value->name}}</a></p>
                        </a>
                    </div>

                    <div class="modal fade" id="section{{$keyicon}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{route('section')}}" method="POST">
                                @csrf  
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel">Personal Details</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label"> First Name</label>
                                            <div>
                                                <input type="name" class="form-control input-lg" name="first_name" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Last Name</label>
                                            <div>
                                                <input type="name" class="form-control input-lg" name="last_name" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Email</label>
                                            <div>
                                                <input type="email" class="form-control input-lg" name="email" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Phone Number</label>
                                            <div>
                                                <input type="text" class="form-control input-lg" name="phone_number" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label">Address</label>
                                            <div>
                                                <input type="text" class="form-control input-lg" name="address" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                @endforeach
            </div>
        </div>
    </div>
</div>    



 @php
$cities = DB::table('cities')->get();
@endphp




<!-- <div class="box_shadow" style="margin-top: 0;">
    <div class="container-fluid w90">
        <div class="projecthome">
            <h2>Properties by locations</h2>
            <div class="row rowm10">
              @php
              $cities = DB::table('cities')->get();
              @endphp
                @foreach ($cities as $keyCiti => $citiValue)
                    <div class="col-2 col-sm-2  col-md-2 colm10">
                        <a href="javascript:void(0)" class="text-center" style="text-decoration: none;color: #1D5F6F;">
                            <img src="{{asset('storage/'.$citiValue->image)}}" style="border-radius: 6px;">
                            <p style="margin-top: 18px;"><b>{{$citiValue->name}}</b></p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>  -->







<div class="box_shadow" style="margin-top: 0;">
    <div class="container-fluid w90">
        <div class="projecthome">
            <h2>Properties by locations</h2>
            <div style="position:relative;">
                <div class="owl-carousel d-block" id="cityslide" style="width: 150px;">
                    @foreach($cities as $city)
                        <div class="item itemarea">
                            <a href="{{ route('public.properties-by-city', $city->slug) }}">
                                <img src="{{asset('storage/'.$city->image)}}" alt="{{ $city->name }}">
                                <h4>{{ $city->name }}</h4>
                            </a>
                        </div>
                    @endforeach
                </div>
                <i class="am-next"><img src="{{ Theme::asset()->url('images/aleft.png') }}" alt="pre"></i>
                <i class="am-prev"><img src="{{ Theme::asset()->url('images/aright.png') }}" alt="next"></i>
            </div>
        </div>
    </div>
</div> 






<div class="box_shadow" style="margin-top: 0;">
    <div class="container-fluid w90">
        <div class="projecthome">
            <h2>Packers and Movers Services</h2>
            <div class="row rowm10">
              @php
              $packers_movers = DB::table('packers_movers')->first();
              @endphp
                
                    <div class="col-10 col-sm-10  col-md-10 colm10">
                        
                            <p><?=$packers_movers->details?></p>
                            <p><a href="#" style="width: 50%;border: 2px solid #1d5f6f;padding: 10px;text-decoration: none;color: black;display: block;text-align: center;" class="section-design" data-toggle="modal" data-target="#movers"><b>Get Your Lowest Price Quote Now</b></a></p>
                        
                    </div>
                    
                    
                    <div class="modal fade" id="movers" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{route('packers_movers')}}" method="POST">
                                @csrf  
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="staticBackdropLabel"><b>Gurranted Lowest Price For Your Moves</b></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label"><b>Moving From</b></label>
                                            <div>
                                                <input type="text" class="form-control input-lg" name="moving_from" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><b>Moving To</b></label>
                                            <div>
                                                <input type="text" class="form-control input-lg" name="moving_to" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><b>Enter Full Name</b></label>
                                            <div>
                                                <input type="text" class="form-control input-lg" name="name" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><b>Email Address</b></label>
                                            <div>
                                                <input type="email" class="form-control input-lg" name="email" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label"><b>Mobile Number</b></label>
                                            <div>
                                                <input type="text" class="form-control input-lg" name="phone_number" >
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label"><b>Property Type</b></label>
                                            <div>
                                                <input type="text" class="form-control input-lg" name="property_type" >
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
            </div>
        </div>
    </div>
</div> 



 


@if ($projects->count())
    <div class="box_shadow" style="margin-top: 0;">
        <div class="container-fluid w90">
            <div class="projecthome">
                <div class="row">
                    <div class="col-12">
                        <h2>{{ __('Featured projects') }}</h2>
                        <p style="margin: 0; margin-bottom: 10px">{{ theme_option('home_project_description') }}</p>
                    </div>
                </div>
                <div class="row rowm10">
                    @foreach ($projects as $project)
                        <div class="col-6 col-sm-4  col-md-3 colm10">
                            {!! Theme::partial('real-estate.projects.item', compact('project')) !!}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif 



