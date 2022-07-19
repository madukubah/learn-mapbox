<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Draft_tender_services
{
	protected $id;
	protected $tender_id ;
	protected $pa_id;
	protected $name;
	protected $contract_type;
	protected $budget_estimation;
	protected $kak_file;
	protected $design_file;
	protected $other_file;
	protected $date;
	protected $status;
  
  function __construct()
  {
      $this->id		      		='';
      $this->tender_id			='';
      $this->pa_id				="";
      $this->name				="";
      $this->contract_type		="";
      $this->budget_estimation	="";
      $this->kak_file		  	="";
      $this->design_file		= '';
	  $this->other_file			= '';
	  $this->date				='';
	  $this->status				='';
	  
  }

  public function __get($var)
  {
    return get_instance()->$var;
  }

  public function get_photo_upload_config( $name = "_" )
  {
    $filename = "TENDER_".time();
    $upload_path = 'uploads/tender/';

    $config['upload_path'] = './'.$upload_path;
    $config['image_path'] = base_url().$upload_path;
    $config['allowed_types'] = "pdf";
    $config['overwrite']="true";
    // $config['max_size']="2048";
    $config['file_name'] = ''.$filename;

    return $config;
  }
  
  public function get_table_config( $_page, $start_number = 1 )
  {
	// sesuaikan nama tabel header yang akan d tampilkan dengan nama atribut dari tabel yang ada dalam database
    $table["header"] = array(
			'name' => 'Tender',
			'pa_name' => 'Pengguna Anggaran',
			'contract_type' => 'Jenis Kontrak',
			'budget_estimation' => 'Harga Perkiraan Sendiri (HPS)',
			'date' => 'Tanggal Mulai Tender',
			//'status' => 'Status',
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
			"button_color" => "warning",
			"param" => "id",
		),
		array(
			"name" => 'X',
			"type" => "modal_delete",
			"modal_id" => "delete_tender_",
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
	public function get_form_data( $draft_tender_id = -1 )
	{
		if( $draft_tender_id != -1 )
		{
			$draft_tender 				= $this->draft_tender_model->draft_tender( $draft_tender_id )->row();
			$this->id					=$draft_tender->id;
			$this->tender_id			=$draft_tender->tender_id;
			$this->pa_id				=$draft_tender->pa_id;
			$this->name					=$draft_tender->name;
			$this->contract_type		=$draft_tender->contract_type;
			$this->budget_estimation	=$draft_tender->budget_estimation;
			$this->kak_file				=$draft_tender->kak_file;
			$this->design_file			=$draft_tender->design_file;
			$this->other_file			=$draft_tender->other_file;
			$this->date					=$draft_tender->date;
			$this->status				=$draft_tender->status;
		}


		$users = $this->ion_auth->users_limit( 1000, 0, 'pa' )->result();
		$user_select = array();
		foreach( $users as $user )
		{
			$user_select[ $user->id ] = $user->first_name." ".$user->last_name;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			),
			"tender_id" => array(
				'type' => 'hidden',
				'label' => "tender_id",
				'value' => $this->form_validation->set_value('tender_id', $this->tender_id),
			),
			"name" => array(
			  'type' => 'text',
			  'label' => "Nama Paket",
			  'readonly' => true,
			  'value' => $this->form_validation->set_value('name', $this->name),
			),
			"pa_id" => array(
				'type' => 'select',
				'label' => "Pengguna Anggaran*",
				'options' => $user_select,
				'selected' => $this->pa_id,
			),
			"contract_type" => array(
				'type' => 'select',
				'label' => "Jenis Kontrak*",
				'options' => array(
					'Lumpsum' => 'Lumpsum',
					'Harga Satuan' => 'Harga Satuan',
				)
				,
				'selected' => $this->form_validation->set_value('contract_type', $this->contract_type),
			),
			"budget_estimation" => array(
			  'type' => 'text',
			  'label' => "Harga Perkiraan Sendiri (HPS)*",
			  'value' => $this->form_validation->set_value('budget_estimation', $this->budget_estimation),
			),
			"kak_file" => array(
				'type' => 'file',
				'label' => "File KAK*",
				'value' => $this->form_validation->set_value('kak_file', $this->kak_file),
			),
			"design_file" => array(
				'type' => 'file',
				'label' => "File Rancangan Kontrak*",
				'value' => $this->form_validation->set_value('design_file', $this->design_file),
			),
			"other_file" => array(
				'type' => 'file',
				'label' => "File Lainnya (Jika Ada)",
				'value' => $this->form_validation->set_value('other_file', $this->other_file),
			),
			//"date" => array(
			//	'type' => 'date',
			//	'label' => "Tanggal",
			//	'value' => $this->form_validation->set_value('date', $this->date),
			//),
			// "status" => array(
			// 	'type' => 'text',
			// 	'label' => "Status",
			// 	'readonly' => true,
			// 	// 'value' => $this->form_validation->set_value('status', $this->status),
			// 	'value' => 'Draft',
			// ),
		  );
		return $_data;
	}

	public function validation_config( ){
	  $config = array(
		  array(
			'field' => 'tender_id',
			'label' => 'tender_id',
			'rules' =>  'trim|required',
		  ),
		  array(
			'field' => 'pa_id',
			'label' => 'pa_id',
			'rules' =>  'trim|required',
		  ),
	  );
	  
	  return $config;
	}
}
?>
