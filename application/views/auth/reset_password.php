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
                  <h3><?php echo lang('reset_password_heading');?></h3>
                </div>
                <div class="col-6">
                  <div class="row">
                    <div class="col-2"></div>
                    <div class="col-10">
                      <div class="float-right">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body">
				<?php echo form_open('auth/reset_password/' . $code);?>

				<p>
					<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label> <br />
					<?php 
						$new_password['class'] = 'form-control';
						echo form_input($new_password);
					?>
				</p>

				<p>
					<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?> <br />
					<?php 
						$new_password_confirm['class'] = 'form-control';
						echo form_input($new_password_confirm);
					?>
				</p>

				<?php echo form_input($user_id);?>

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
