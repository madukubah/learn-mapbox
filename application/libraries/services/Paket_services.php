<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Paket_services
{
	protected $id;
	protected $name;
	protected $description;
	protected $start_date;
	protected $end_date;
	protected $latitude;
	protected $longitude;
  	protected $physical_progress ;
  	protected $monetary_progress ;
  
  function __construct()
  {
      $this->id		      			='';
      $this->name					='';
      $this->description			="";
      $this->start_date				="";
      $this->end_date		  		="";
      $this->latitude				="";
      $this->longitude		  		="";
      $this->physical_progress		= '';
      $this->monetary_progress		= '';
  }

  public function __get($var)
  {
    return get_instance()->$var;
  }
  public function get_photo_upload_config( $name = "_" )
  {
    $filename = "USER_".$name."_".time();
    $upload_path = 'uploads/users_photo/';

    $config['upload_path'] = './'.$upload_path;
    $config['image_path'] = base_url().$upload_path;
    $config['allowed_types'] = "gif|jpg|png|jpeg";
    $config['overwrite']="true";
    $config['max_size']="2048";
    $config['file_name'] = ''.$filename;

    return $config;
  }
  
  public function get_table_config( $_page, $start_number = 1 )
  {
	// sesuaikan nama tabel header yang akan d tampilkan dengan nama atribut dari tabel yang ada dalam database
    $table["header"] = array(
			'name' => 'Nama Paket',
			'start_date' => 'Mulai',
			'end_date' => 'Selesai',
			'physical_progress' => 'Progress Fisik (%)',
			'monetary_progress' => 'Progress Keuangan (%)',
		  );
		  $table["number"] = $start_number ;
		  $table[ "action" ] = array(
			array(
			  "name" => "Detail",
			  "type" => "link",
			  "url" => site_url($_page."detail/"),
			  "button_color" => "primary",
			  "param" => "id",
			),
			array(
			  "name" => "Edit",
			  "type" => "link",
			  "url" => site_url($_page."edit/"),
			  "button_color" => "primary",
			  "param" => "id",
			),
			array(
			  "name" => 'X',
			  "type" => "modal_delete",
			  "modal_id" => "delete_paket_",
			  "url" => site_url( $_page."delete/"),
			  "button_color" => "danger",
			  "param" => "id",
			  "form_data" => array(
				"id" => array(
				  'type' => 'hidden',
				  'label' => "id",
				),
				"group_id" => array(
				  'type' => 'hidden',
				  'label' => "group_id",
				),
			  ),
			  "title" => "Paket",
			  "data_name" => "name",
			),
		);
    return $table;
  }

  /**
	 * get_form_data
	 *
	 * @return array
	 * @author madukubah
	 **/
	public function get_form_data( $paket_id = -1 )
	{
		if( $paket_id != -1 )
		{
			$paket 					= $this->paket_model->paket( $paket_id )->row();
			$this->id				=$paket->id;
			$this->name				=$paket->name;
			$this->description		=$paket->description;
			$this->start_date		=$paket->start_date;
			$this->end_date			=$paket->end_date;
			$this->latitude			=$paket->latitude;
			$this->longitude		=$paket->longitude;
			$this->physical_progress=$paket->physical_progress;
			$this->monetary_progress=$paket->monetary_progress;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			),
			"name" => array(
			  'type' => 'text',
			  'label' => "Nama Paket",
			  'value' => $this->form_validation->set_value('name', $this->name),
			),
			"summernote" => array(
			  'type' => 'textarea',
			  'label' => "Deskripsi",
			  'value' => $this->form_validation->set_value('summernote', $this->description),
			),
			"start_date" => array(
			  'type' => 'date',
			  'label' => "Mulai",
			  'value' => $this->form_validation->set_value('start_date', $this->start_date),
			),
			"end_date" => array(
			  'type' => 'date',
			  'label' => "Selesai",
			  'value' => $this->form_validation->set_value('end_date', $this->end_date),
			),
			"physical_progress" => array(
				'type' => 'number',
				'label' => "Progress Fisik",
				'value' => $this->form_validation->set_value('physical_progress', $this->physical_progress),
			),
			"monetary_progress" => array(
				'type' => 'number',
				'label' => "Progress Keuangan",
				'value' => $this->form_validation->set_value('monetary_progress', $this->monetary_progress),
			),
			"latitude" => array(
			  'type' => 'text',
			//   'readonly' => 'readonly',
			  'label' => "Latitude",
			  'value' => $this->form_validation->set_value('latitude', $this->latitude),
			),
			"longitude" => array(
			  'type' => 'text',
			//   'readonly' => 'readonly',
			  'label' => "Longitude",
			  'value' => $this->form_validation->set_value('longitude', $this->longitude),
			),
		  );
		return $_data;
	}

	public function validation_config( ){
	  $config = array(
		  array(
			'field' => 'name',
			'label' => 'name',
			'rules' =>  'trim|required',
		  ),
		  array(
			'field' => 'summernote',
			'label' => 'description',
			'rules' =>  'trim|required',
		  ),
	  );
	  
	  return $config;
	}
}
?>
