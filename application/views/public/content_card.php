
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