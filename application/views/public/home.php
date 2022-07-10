<!-- Promo Block -->
  <div class="col-md-12" style="height:100vh; background: #f15f79;
      background: linear-gradient(to bottom, #2C5F78 0%,#b24592 100%); padding-top: 12px">
      
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-8">
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
                    <?php echo ($header) ?>
                  </h5>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                      <div class="float-right">
                        <?php echo (isset( $header_button )) ? $header_button : '';  ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!--  -->
              <?php echo (isset($contents)) ? $contents : '';  ?>
              <!--  -->
              <!--  -->
              <?php echo (isset($pagination_links)) ? $pagination_links : '';  ?>
              <!--  -->
            </div>
          </div>
        </div>
        <!--  -->
        <div class="col-4">
          <div class="card">
            <div class="card-header">
              <h5>
                Berita
              </h5>
            </div>
            <div class="card-body">
              <b>26 Juni 2022 13:22</b><br>
              <a href="#">Informasi Maintenance LPSE</a><br>
              <b>10 Juni 2022 13:13</b><br>
              <a href="#">Maintenance Server</a><br>
              <b>9 Juni 2022 11:14</b><br>
              <a href="#">Undangan</a><br>
              <b>3 Juni 2022 00:52</b><br>
              <a href="#">Batas penginputan P3DN Tanggal 27 Mei 2022 instruksi Presiden Joko Widodo</a><br>
              <b>3 Juni 2022 00:47</b><br>
              <a href="#">pemberitahuan</a><br>
            </div>
          </div>
        </div>
        <!--  -->
      </div>
    </div>
  </section>
  </div>
<!-- End Promo Block -->
