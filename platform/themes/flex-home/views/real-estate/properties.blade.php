@php
    if (theme_option('show_map_on_properties_page', 'yes') == 'yes') {
        Theme::asset()->usePath()->add('leaflet-css', 'libraries/leaflet.css');
        Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'libraries/leaflet.js');
        Theme::asset()->container('footer')->usePath()->add('leaflet.markercluster-src-js', 'libraries/leaflet.markercluster-src.js');
    }
@endphp

<section class="main-homes pb-3">
    <div class="bgheadproject hidden-xs" style="background: url('{{ theme_option('breadcrumb_background') ? RvMedia::url(theme_option('breadcrumb_background')) : Theme::asset()->url('images/banner-du-an.jpg') }}')">
        <div class="description">
            <div class="container-fluid w90">
                <h1 class="text-center">{{ SeoHelper::getTitle() }}</h1>
                <p class="text-center">{{ theme_option('properties_description') }}</p>
                {!! Theme::partial('breadcrumb') !!}
            </div>
        </div>
    </div>
    <div class="container-fluid w90 padtop30">
        <div class="projecthome">
            <form action="{{ route('public.properties') }}" method="get" id="ajax-filters-form">
                @include(Theme::getThemeNamespace() . '::views.real-estate.includes.search-box', ['type' => 'property', 'categories' => $categories])
                <div class="row rowm10">
                    <div class="@if (theme_option('show_map_on_properties_page', 'yes') == 'yes') col-lg-7 left-page-content @else col-lg-12 full-page-content @endif"
                         @if (theme_option('show_map_on_properties_page', 'yes') == 'yes')
                        data-class-full="col-lg-12 full-page-content"
                        data-class-left="col-lg-7 left-page-content"
                     @endif
                         id="properties-list">
                        @include(Theme::getThemeNamespace() . '::views.real-estate.includes.filters', ['isChangeView' => theme_option('show_map_on_properties_page', 'yes') == 'yes'])
                        <div class="data-listing mt-2">
                            
                            {!! Theme::partial('real-estate.properties.items', compact('properties')) !!}
                        </div>
                    </div>
                    @if (theme_option('show_map_on_properties_page', 'yes') == 'yes')
                        <div class="col-md-5 @if (!Arr::get($_COOKIE, 'show_map_on_properties', 1)) d-none @endif" id="properties-map" style="display: none;">
                            <div class="rightmap h-100">
                                <div
                                    id="map"
                                    data-type="{{ request()->input('type') }}"
                                    data-url="{{ route('public.ajax.properties.map') }}"
                                    data-center="{{ json_encode([43.615134, -76.393186]) }}"></div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-5">
                        <div id="mapCanvas" style="width: 100%;height: 32%;position: absolute;overflow: hidden;"></div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>

@if (theme_option('show_map_on_properties_page', 'yes') == 'yes')
    <script id="traffic-popup-map-template" type="text/x-custom-template">
        {!! Theme::partial('real-estate.properties.map', ['property' => get_object_property_map()]) !!}
    </script>
@endif
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxYNofOwLqa8Vm59-a9XyRoTQ-pUCPC1U"></script>
<?php
    $m = 0;
    $data = array();
    foreach ($properties as $key => $value) {
        if($value->latitude){
            $data[$m]['lat'] = $value->latitude;
            $data[$m]['long'] = $value->longitude;
            $data[$m]['name'] = $value->name;

            $m++;
        }
    }
    // echo "<pre>";
    // print_r($data);
    // die();
?>

<script type="text/javascript">
    function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };
                    
    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50);
        
    // Multiple markers location, latitude, and longitude
    var markers = [
        <?php 
            for($i=0;$i<count($data);$i++){
                echo '["TESY", '.$data[$i]['lat'].', '.$data[$i]['long'].'],';
            }
        
        ?>
    ];
                        
    // Info window content
    var infoWindowContent = [
        <?php 
            for($i=0;$i<count($data);$i++){ ?>
                ['<div class="info_content">' +
                '<h3><?php echo $data[$i]['name']; ?></h3>' +
                '</div>'],
        <?php }
        
        ?>
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(4);
        google.maps.event.removeListener(boundsListener);
    });
    
}

// Load initialize function
google.maps.event.addDomListener(window, 'load', initMap);
</script>
