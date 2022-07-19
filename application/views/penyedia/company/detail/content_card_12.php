
<!--  -->
<div class="col-12">
  <div class="card">
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <h5>
            <?php echo strtoupper($header) ?>
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
        <!-- <div id='map' style='width: 100%; height: 500px;'></div> -->
      <!--  -->
    </div>
  </div>
</div>
<!--  -->