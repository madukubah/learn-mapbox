
<script src='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.3.1/mapbox-gl.css' rel='stylesheet' />
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <!-- <h5 class="m-0 text-dark"><?php echo $block_header ?></h5> -->
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
                <!-- <textarea class="summernote" name="" id="summernote" cols="30" rows="10"></textarea> -->
                <?php echo (isset($contents)) ? $contents : '';  ?>
                <div id='map' style='width: 100%; height: 500px;'></div>
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
    
    map.on('load', () => {

      const lat = document.getElementById("latitude").value;
      const lng = document.getElementById("longitude").value;
      const marker =  new mapboxgl.Marker().setLngLat([ lng, lat ]).addTo(map);

    });
</script>