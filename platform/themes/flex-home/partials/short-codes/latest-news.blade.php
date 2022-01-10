@if (is_plugin_active('blog'))
    <div class="box_shadow" style="margin-bottom: 0;padding-bottom: 80px;">
        <div class="container-fluid w90">
            <div class="discover">
                <div class="row">
                    <div class="col-12">
                        <h2>{{ __('News') }}</h2>
                        <p>{{ theme_option('home_description_for_news') }}</p>
                        <br>
                        <div class="blog-container">
                            <news-component url="{{ route('public.ajax.posts') }}"></news-component>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />
<div class="box_shadow" style="margin-bottom: 0;padding-bottom: 80px;">
    <div class="container-fluid w90">
        <div class="discover">
            <div class="row">
                <div class="col-12">
                    <h2>{{ __('News') }}</h2>
                    <br>
                    <div class="blog-container">
                        <div class="owl-carousel">
                            <div class="item"> Your Content </div>
                            <div class="item"> Your Content </div>
                            <div class="item"> Your Content </div>
                            <div class="item"> Your Content </div>
                            <div class="item"> Your Content </div>
                            <div class="item"> Your Content </div>
                            <div class="item"> Your Content </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" ></script>
<script type="text/javascript">
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        items:4,
        loop:false,
        margin:10,
        autoplay:true,
        autoplayTimeout:1000,
        autoplayHoverPause:true,
        width:'100%'
    });
</script> -->
