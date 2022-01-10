@php
    SeoHelper::setTitle(__('Service'));
    Theme::fire('beforeRenderTheme', app(\Botble\Theme\Contracts\Theme::class));
@endphp

{!! Theme::partial('header') !!}
<?php
    $sqlService = DB::table('maintenance')->where('slug',request()->route('slug'))->first();
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<div class="container padtop50">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="page-header">
                    <h1>
                        <?=ucfirst($sqlService->name)?>
                    </h1>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @php
                                            $images = json_decode($sqlService->image,true);

                                        @endphp
                                        @foreach($images as $imKey => $imValue)
                                        <li data-bs-target="#myCarousel" data-bs-slide-to="{{$imKey}}" class="{{($imKey == 0)?'active':''}}"></li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner">
                                        @foreach($images as $imKey => $imValue)
                                        <div class="carousel-item {{($imKey == 0)?'active':''}}">
                                            <img src="{{asset($imValue)}}" class="d-block w-100" alt="Slide {{$imKey}}">
                                        </div>
                                        @endforeach
                                    </div>
                                    <a class="carousel-control-prev" href="#myCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#myCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <?=$sqlService->description?>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <video width="100%" style="max-height: 211px;" controls>
                                    <source src="{{asset($sqlService->video)}}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-3 bg-light">
                    <form action="{{route('section')}}" method="POST">
                        @csrf  
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"> First Name</label>
                                    <div>
                                        <input type="name" class="form-control input-lg" name="first_name" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Last Name</label>
                                    <div>
                                        <input type="name" class="form-control input-lg" name="last_name" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <div>
                                        <input type="email" class="form-control input-lg" name="email" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Phone Number</label>
                                    <div>
                                        <input type="text" class="form-control input-lg" name="phone_number" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <div>
                                        <input type="text" class="form-control input-lg" name="address" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{!! Theme::partial('footer') !!}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    $('.carousel').carousel({
  interval: 2000
});
</script>


