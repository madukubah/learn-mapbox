<?php $this->load->library(array('form_validation'));  ?>
<!-- - -->
<div class="row">
<?php foreach ($form_data as $form_name => $attr) : ?>
    <?php
        if ($attr['type'] == 'hidden') {
            $form = array(
                'name' => $form_name,
                'type' => $attr['type'],
                'placeholder' => (isset($attr['label'])) ? $attr['label'] : '',


            );
            $value = ((isset($data) && ($data != NULL))   ? (isset($data->$form_name) ? $data->$form_name : '') : '');
            $form['value'] = (isset($attr['value'])) ? $attr['value'] : $value;
            echo form_input($form);
            continue;
        }
        ?>
    
        <div class="col">
            <?php
                $form = array(
                    'name' => $form_name,
                    'id' => $form_name,
                    'type' => $attr['type'],
                    'placeholder' => (isset($attr['label'])) ? $attr['label'] : '',
                    'class' => 'form-control',

                );
                if (isset($attr['readonly']))  $form['readonly'] = '';

                switch ($attr['type']) {
                    case 'date':
                        $form['class'] = "form-control datepicker";
                        $form['type'] = "text";
                    case 'password':
                    case 'email':
                    case 'text':
                    case 'number':
                        $value = ((isset($data) && ($data != NULL))   ? (isset($data->$form_name) ? $data->$form_name : '') : '');
                        $form['value'] = (isset($attr['value'])) ? $attr['value'] : $value;
                        echo form_input($form);
                        break;
                    case 'hidden':
                        $value = ((isset($data) && ($data != NULL))   ? (isset($data->$form_name) ? $data->$form_name : '') : '');
                        $form['value'] = (isset($attr['value'])) ? $attr['value'] : $value;
                        echo form_input($form);
                        break;
                    case 'textarea':
                        $value = ((isset($data) && ($data != NULL))   ? (isset($data->$form_name) ? $data->$form_name : '') : '');
                        $form['rows'] = "5";
                        $form['value'] = (isset($attr['value'])) ? $attr['value'] : $value;
                        echo form_textarea($form);
                        break;
                    case 'multiple_file':
                        $form['multiple'] = "";
                    case 'file':
                        echo form_upload($form);
                        break;
                    case 'select_search':
                        $form['class'] = 'form-control show-tick';
                        $form['data-live-search'] = 'true';
                    case 'select':
                        $form['options'] = (isset($attr['options'])) ? $attr['options'] : '';
                        $value = ((isset($data) && ($data != NULL))   ? (isset($data->$form_name) ? $data->$form_name : '') : '');
                        $form['selected'] = (isset($attr['selected'])) ? $attr['selected'] : $value;
                        echo form_dropdown($form);
                        break;
                }
                ?>
        </div>
<?php endforeach; ?>
</div>
<!--  -->