
<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
<style>
    .marker {
        /* background-image: url('mapbox-icon.png'); */
        background-color: "red";
        background-size: cover;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>
<div class="content-wrapper">
  <div class="content-header">
    
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" method="GET" >
                        <div class="row mb-2 ">
                            <div class="col-lg-6 col-sm-12 col-md-12 col-xs-12">
                                <?= $form_filter ?>
                            </div>
                            <div class="col-2" style="margin-top:3px">
                                <button type="submit" class="btn btn-primary btn-sm"  style="margin-left: 5px;">
                                    ok
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
            <div id='map' style='width: 100%; height: 500px;'></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<textarea id="paket" style="display:none">
    <?= json_encode( $paket );?>
</textarea>
<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoibWFkdWt1YmFoIiwiYSI6ImNrdHRtd2s4cTAyZnUyb214eW96OTkwanUifQ.IgNRk8pFnkH-nCc3I5FqeQ';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [122.514900, -3.972201],
        zoom: 11.15
    });

    const pakets = JSON.parse(document.getElementById('paket').value);
    const features = []
    for (var i = 0; i < pakets.length; i++) {
        features.push(
            {
                'type': 'Feature',
                'properties': {
                    'description':
                    '<div style="max-height:300px; overflow-y: scroll" > '+pakets[i].description+'<img class="img-fluid" src="<?php echo base_url("uploads/paket/")?>'+pakets[i].image+'" />'+'<a href="<?php echo site_url("uadmin/paket/detail/")?>'+pakets[i].id+'" >Detail</a>'+'</div>',
                    'icon': 'harbor_icon'
                    },
                'geometry': {
                    'type': 'Point',
                    'coordinates': [ pakets[i].longitude, pakets[i].latitude]
                }
            },
        );
    }
    
    map.on('load', () => {
        map.addSource('places', {
        // This GeoJSON contains features that include an "icon"
        // property. The value of the "icon" property corresponds
        // to an image in the Mapbox Streets style's sprite.
            'type': 'geojson',
            'data': {
                'type': 'FeatureCollection',
                'features': features
            }
        });

        map.loadImage(
            '<?php echo base_url()?>/uploads/location.png',
            (error, image) => {
            if (error) throw error;
            
            // Add the image to the map style.
            map.addImage('marker', image);

            // Add a layer showing the places.
            map.addLayer({
                'id': 'places',
                'type': 'symbol',
                'source': 'places',
                'layout': {
                'icon-image': 'marker',
                'icon-allow-overlap': true,
                'icon-size': 0.1
                }
            });
        });
    
        // When a click event occurs on a feature in the places layer, open a popup at the
        // location of the feature, with description HTML from its properties.
        map.on('click', 'places', (e) => {
            // Copy coordinates array.
            const coordinates = e.features[0].geometry.coordinates.slice();
            const description = e.features[0].properties.description;
            // Ensure that if the map is zoomed out such that multiple
            // copies of the feature are visible, the popup appears
            // over the copy being pointed to.
            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
            coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
            }
            
            new mapboxgl.Popup()
            .setLngLat(coordinates)
            .setHTML(description)
            .setMaxWidth("500px")
            .addTo(map);
        });
    
        // Change the cursor to a pointer when the mouse is over the places layer.
        map.on('mouseenter', 'places', () => {
            map.getCanvas().style.cursor = 'pointer';
        });
        
        // Change it back to a pointer when it leaves.
        map.on('mouseleave', 'places', () => {
            map.getCanvas().style.cursor = '';
        });
    });
</script>


