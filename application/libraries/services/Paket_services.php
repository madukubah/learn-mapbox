<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Paket_services
{
	protected $id;
	protected $draft_tender_id;
	protected $pa_id;
	protected $name;
	protected $pokmil_id;
	protected $date;
	protected $status;
  
  function __construct()
  {
      $this->id		      		='';
      $this->draft_tender_id	='';
      $this->pa_id				="";
      $this->name				="";
      $this->pokmil_id		  	="";
      $this->date				="";
      $this->status		  		="";
  }

  public function __get($var)
  {
    return get_instance()->$var;
  }

  public function get_photo_upload_config( $name = "_" )
  {
    $filename = "PAKET_".time();
    $upload_path = 'uploads/paket/';

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
			'pa_full_name' => 'Pengguna Anggaran',
			'pokmil_name' => 'Pokmil',
			'date' => 'Tanggal Buat Paket',
		  );
	$table["number"] = $start_number ;
	$table[ "action" ] = array(
		array(
			"name" => "Detail",
			"type" => "link",
			"url" => site_url($_page."detail/"),
			"button_color" => "primary",
			"param" => "id_enc",
		),
		array(
			"name" => "Edit",
			"type" => "link",
			"url" => site_url($_page."edit/"),
			"button_color" => "warning",
			"param" => "id_enc",
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
			$this->draft_tender_id	=$paket->draft_tender_id;
			$this->pa_id			=$paket->pa_id;
			$this->name				=$paket->name;
			$this->pokmil_id		=$paket->pokmil_id;
			$this->date				=$paket->date;
			$this->status			=$paket->status;
		}
		$pokmils = $this->pokmil_model->pokmils( )->result();
		$pokmil_select = array(
			'' => 'Pilih' 
		);
		foreach( $pokmils as $pokmil )
		{
			$pokmil_select[ $pokmil->id ] = $pokmil->name;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			),
			"draft_tender_id" => array(
				'type' => 'hidden',
				'label' => "draft_tender_id",
				'value' => $this->form_validation->set_value('draft_tender_id', $this->draft_tender_id),
			),
			"pa_id" => array(
				'type' => 'hidden',
				'label' => "pa_id",
				'value' => $this->form_validation->set_value('pa_id', $this->pa_id),
			),
			"name" => array(
			  'type' => 'text',
			  'label' => "Nama Paket",
			  'readonly' => true,
			  'value' => $this->form_validation->set_value('name', $this->name),
			),
			"pokmil_id" => array(
				'type' => 'select',
				'label' => "Pokmil",
				'options' => $pokmil_select,
				'selected' => $this->pokmil_id,
			),
			"date" => array(
				'type' => 'date',
				'label' => "Tanggal Buat Paket",
				'value' => $this->form_validation->set_value('date', $this->date),
			),
			"status" => array(
				'type' => 'select',
				'label' => "Status",
				'options' => array(
					'Aktif' => 'Aktif',
					'Non Aktif' => 'Non Aktif'
				)
				,
				'selected' => $this->form_validation->set_value('status', $this->status),
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
			'field' => 'pokmil_id',
			'label' => 'pokmil_id',
			'rules' =>  'trim|required',
		  ),
	  );
	  
	  return $config;
	}
}
?>
