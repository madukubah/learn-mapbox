
<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0 text-dark"><?php echo $block_header ?></h5>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="col-12">
                <?php
                echo $alert;
                ?>
              </div>
              <div class="row">
                <div class="col-6">
                  <h5>
                    <?php echo strtoupper($header) ?>
                    <p class="text-secondary"><small><?php echo $sub_header ?></small></p>
                  </h5>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                      <div class="float-right">
                        <?php echo (isset($header_button)) ? $header_button : '';  ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
                <!--  -->
                <?php echo form_open_multipart();  ?>
                <!-- <textarea class="summernote" name="" id="summernote" cols="30" rows="10"></textarea> -->
                <?php echo (isset($contents)) ? $contents : '';  ?>
                <div id='map' style='width: 100%; height: 500px;'></div>

                <button class="btn btn-bold btn-success btn-sm " style="margin-left: 5px;" type="submit">
                    Simpan
                </button>

                <?php echo form_close()  ?>
              <!--  -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<script>
	mapboxgl.accessToken = 'pk.eyJ1IjoibWFkdWt1YmFoIiwiYSI6ImNrdHRtd2s4cTAyZnUyb214eW96OTkwanUifQ.IgNRk8pFnkH-nCc3I5FqeQ';
    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [122.514900, -3.972201],
        zoom: 11.15
    });
    
    const currentMarkers=[];

    map.on('load', () => {

      const lat = document.getElementById("latitude").value;
      const lng = document.getElementById("longitude").value;
      const marker =  new mapboxgl.Marker().setLngLat([ lng, lat ]).addTo(map);
      currentMarkers.push(marker);

        map.on('click',(e) => {

            for (let i = currentMarkers.length - 1; i >= 0; i--) {
                currentMarkers[i].remove();
            }
            // make a marker for each feature and add to the map
            const marker =  new mapboxgl.Marker().setLngLat([ e.lngLat.lng, e.lngLat.lat ]).addTo(map);
            document.getElementById("latitude").value = e.lngLat.lat
            document.getElementById("longitude").value = e.lngLat.lng

            currentMarkers.push(marker);
        });

    });
</script>
<script>
      // console.log( "ceiling_budget" );
    $(document).ready(function() {

      $("#latitude").change(function( e ){
          console.log( $( this ).val() );
          setMarker( $( "#longitude" ).val() , $( this ).val());
      });

      $("#longitude").change(function(){
          console.log( $( this ).val() );
          setMarker( $( this ).val(), $( "#latitude" ).val() );
      });

      function setMarker( lng=0, lat=0 )
      {
        console.log( parseFloat(lng) );
        console.log( parseFloat(lat) );

        for (let i = currentMarkers.length - 1; i >= 0; i--) {
            currentMarkers[i].remove();
        }
        // make a marker for each feature and add to the map
        const marker =  new mapboxgl.Marker().setLngLat([ parseFloat(lng), parseFloat(lat) ]).addTo(map);

        currentMarkers.push(marker);
        console.log( currentMarkers.length );
      }

    });
</script>