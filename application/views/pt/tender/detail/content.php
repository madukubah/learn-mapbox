
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
          <div class="p-3">
            <div class="row">
              <div class="col-12">
                <?php
                  echo $alert;
                ?>
              </div>
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
          <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Tender</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill" href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Penyedia</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="custom-tabs-four-schedule-tab" data-toggle="pill" href="#custom-tabs-four-schedule" role="tab" aria-controls="custom-tabs-three-schedule" aria-selected="false">Jadwal</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
              <?php echo (isset($contents)) ? $contents : '';  ?>
              <?php

                echo '<label for="requirement_file" class="control-label">File Persyaratan</label><br>';
                if( $tender->requirement_file )
                  echo '<a href="'.base_url("uploads/tender/").$tender->requirement_file.'">  File Persyaratan </a>';
                else
                  echo 'None';
                echo form_open_multipart(site_url('pt/tender/upload_file/'.$tender->id));
                $form = array(
                    'name' => 'tender_id',
                    'id' => 'tender_id',
                    'type' => 'hidden',
                    'value' => $tender->id
                    
                );
                echo form_input( $form );
                $form = array(
                    'name' => 'requirement_file',
                    'id' => 'requirement_file',
                    'type' => 'file',
                    'placeholder' => 'File Persyaratan' ,
                    
                );
                echo form_upload( $form );
                ?>
                <button class="btn btn-bold btn-success btn-sm " style="margin-left: 5px;" type="submit">
                  Simpan
                </button>
                <?php
                echo form_close();
              ?>

              <?php

              echo '<label for="election_file" class="control-label">Dokumen Pemilihan</label><br>';
              if( $tender->election_file )
                echo '<a href="'.base_url("uploads/tender/").$tender->election_file.'">  Dokumen Pemilihan </a>';
              else
                echo 'None';
              echo form_open_multipart(site_url('pt/tender/upload_file/'.$tender->id));
              $form = array(
                  'name' => 'tender_id',
                  'id' => 'tender_id',
                  'type' => 'hidden',
                  'value' => $tender->id
                  
              );
              echo form_input( $form );
              $form = array(
                  'name' => 'election_file',
                  'id' => 'election_file',
                  'type' => 'file',
                  'placeholder' => 'Dokumen Pemilihan' ,
                  
              );
              echo form_upload( $form );
              ?>
              <button class="btn btn-bold btn-success btn-sm " style="margin-left: 5px;" type="submit">
                Simpan
              </button>
              <?php
              echo form_close();
              ?>
            </div>
            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
              <?php echo (isset($contents_2)) ? $contents_2 : '';  ?>
            </div>
            <div class="tab-pane fade" id="custom-tabs-four-schedule" role="tabpanel" aria-labelledby="custom-tabs-four-schedule-tab">
              <?php echo (isset($contents_3)) ? $contents_3 : '';  ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
