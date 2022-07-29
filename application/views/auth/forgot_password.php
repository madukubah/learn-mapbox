<!-- Promo Block -->
<div class="col-md-12" style="height:100vh; background: #f15f79;
      background: linear-gradient(to bottom, #2C5F78 0%,#b24592 100%); padding-top: 12px">
      
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="col-12">
                  <div id="infoMessage"><?php echo $message;?></div>
              </div>
              <div class="row">
                <div class="col-6">
                  <h3><?php echo lang('forgot_password_heading');?></h3>
                  <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>
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
                  <?php echo form_open("auth/forgot_password");?>
                  <p>
                        <label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label> <br />
                        <?php 
                              $identity['class'] = 'form-control';
                              echo form_input($identity);
                        ?>
                  </p>

                  <button class="btn btn-bold btn-success btn-sm " style="margin-left: 5px;" type="submit">
                  Kirim
                  </button>

                  <?php echo form_close();?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  </div>
<!-- End Promo Block -->
