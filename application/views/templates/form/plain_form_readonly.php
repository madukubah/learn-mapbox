
 <?php  $this->load->library( array( 'form_validation' ) );  ?>
 <!-- - -->
 <?php foreach( $form_data as $form_name => $attr ): ?>
    <?php
        if( $attr['type'] == 'hidden' )
        {
            $form = array(
                'name' => $form_name,
                'type' => $attr['type'],
                'placeholder' => ( isset( $attr['label'] )  ) ? $attr['label'] : '' ,
                    
                
            );
            $value = ( ( isset( $data ) && ( $data != NULL) )   ? ( isset( $data->$form_name ) ? $data->$form_name : '' ) : ''  );
            $form['value'] = ( isset( $attr['value'] )  ) ? $attr['value'] : $value;
            echo form_input( $form );
            continue;
        }
    ?>
    <div class="row">
        <div class="col-md-12">
        <?php
            $form = array(
                'name' => $form_name,
                'id' => $form_name,
                'type' => $attr['type'],
                'placeholder' => ( isset( $attr['label'] )  ) ? $attr['label'] : '' ,
                'class' => 'form-control',  
                
            );
            $form['readonly'] = '';

            switch(  $attr['type'] )
            {
                case 'date':
                    // $form['class'] = "form-control datepicker";
                    $form['class'] = "form-control";
                    $form['type'] = "date";
                    $value = ( ( isset( $data ) && ( $data != NULL) )   ? ( isset( $data->$form_name ) ? $data->$form_name : '' ) : ''  );
                    $form['value'] = ( isset( $attr['value'] )  ) ? $attr['value'] : $value;
                    echo '<label for="'.$form_name.'" class="control-label">'.$attr["label"].'</label>';
                    echo form_input( $form );
                    break;
                case 'password':
                case 'email':
                case 'text':
                case 'number':
                    $value = ( ( isset( $data ) && ( $data != NULL) )   ? ( isset( $data->$form_name ) ? $data->$form_name : '' ) : ''  );
                    $form['value'] = ( isset( $attr['value'] )  ) ? $attr['value'] : $value;
                    if (is_numeric( $form['value'] ) )
                    {
                        $form['type'] = 'text';
                        $form['value'] = number_format( $form['value'] );
                    }
                    echo '<label for="'.$form_name.'" class="control-label">'.$attr["label"].'</label>';
                    echo form_input( $form );
                    break;
                case 'hidden':
                    $value = ( ( isset( $data ) && ( $data != NULL) )   ? ( isset( $data->$form_name ) ? $data->$form_name : '' ) : ''  );
                    $form['value'] = ( isset( $attr['value'] )  ) ? $attr['value'] : $value;
                    echo form_input( $form );
                    break;
                case 'textarea':
                    $value = ( ( isset( $data ) && ( $data != NULL) )   ? ( isset( $data->$form_name ) ? $data->$form_name : '' ) : ''  );
                    $form['rows'] = "5";
                    $form['value'] =  ( isset( $attr['value'] )  ) ? $attr['value'] : $value;
                    echo '<label for="" class="control-label">'.$attr["label"].'</label>';
                    // echo form_textarea( $form );
                    echo '<div class="card"><div class="card-body">'. $form['value']. '</div></div>';
                    break;
                case 'multiple_file':
                    $form['multiple'] = "";
                case 'file':
                    echo '<label for="" class="control-label">'.$attr["label"].'</label>';
                    // echo form_upload( $form );
                    $form['value'] = ( isset( $attr['value'] )  ) ? $attr['value'] : $value;
                    echo '<br/>';
                    echo '<img class="img-fluid" src="'.base_url("uploads/paket/").$form['value'].'" />';
                    break;
                case 'select_search':
                    $form['class'] = 'form-control show-tick';
                    $form['data-live-search'] = 'true';
                case 'select':
                    $form['options'] = ( isset( $attr['options'] )  ) ? $attr['options'] : '';
                    $value = ( ( isset( $data ) && ( $data != NULL) )   ? ( isset( $data->$form_name ) ? $data->$form_name : '' ) : ''  );
                    $form['selected'] = ( isset( $attr['selected'] )  ) ? $attr['selected'] : $value;
                    if( $form['selected'] != 0 || $form['selected'] != '' )
                        $form['value'] = $form['options'][$form['selected']];
                    else
                        $form['value'] = '';
                    unset( $form['options']);
                    unset( $form['selected'] );

                    echo '<label for="" class="control-label">'.$attr["label"].'</label>';
                    echo form_input( $form );
                    break;
            }
        ?>
        </div>
    </div>
<?php endforeach; ?>
<br>

<!--  -->