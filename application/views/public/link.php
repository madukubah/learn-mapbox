<?php
$data_param = ((isset($param) && isset($data->$param)) ? $data->$param : "");
$get = ((isset($get)) ? $get : "");
?>
<a href="<?php echo $url . $data_param . $get; ?>" class=" btn btn-xs btn-<?php echo $button_color ?>"><?php echo $name ?></a>