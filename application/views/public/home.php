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
              <?php foreach( $newss as $news ):?>
                <b><?= date('d M Y H:i', time($news->datetime))?></b><br>
                <a href="#"><?= $news->content?></a><br>
              <?php endforeach;?>
            </div>
          </div>
        </div>
        <!--  -->
      </div>
    </div>
  </section>
  </div>
<!-- End Promo Block -->
