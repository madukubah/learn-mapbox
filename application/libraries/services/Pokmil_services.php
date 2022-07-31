<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Pokmil_services
{
	protected $id;
	protected $name ;
	protected $sk_no;
	protected $lead_id;
	protected $member_1_id;
	protected $member_2_id;
	protected $member_3_id;
	protected $member_4_id;
	protected $date;
	protected $status;
  
  function __construct()
  {
      $this->id		      		='';
      $this->name				='';
      $this->sk_no				="";
      $this->lead_id			="";
      $this->member_1_id		="";
      $this->member_2_id		="";
      $this->member_3_id		="";
      $this->member_4_id		= '';
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
    $config['allowed_types'] = "pdf|docx";
    $config['overwrite']="true";
    // $config['max_size']="2048";
    // $config['file_name'] = ''.$filename;

    return $config;
  }
  
  public function get_table_config( $_page, $start_number = 1 )
  {
	// sesuaikan nama tabel header yang akan d tampilkan dengan nama atribut dari tabel yang ada dalam database
    $table["header"] = array(
			'name' => 'Nama',
			'sk_no' => 'No SK Pokmil',
			'lead_full_name' => 'Ketua',
		  );
	$table["number"] = $start_number ;
	$table["search"] = array(
		"field" => "name"
	);
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
	public function get_form_data( $pokmil_id = -1 )
	{
		if( $pokmil_id != -1 )
		{
			$pokmil 					= $this->pokmil_model->pokmil( $pokmil_id )->row();
			$this->id					=$pokmil->id;
			$this->name					=$pokmil->name;
			$this->sk_no				=$pokmil->sk_no;
			$this->lead_id				=$pokmil->lead_id;
			$this->member_1_id			=$pokmil->member_1_id;
			$this->member_2_id			=$pokmil->member_2_id;
			$this->member_3_id			=$pokmil->member_3_id;
			$this->member_4_id			=$pokmil->member_4_id;
			$this->date					=$pokmil->date;
			$this->status				=$pokmil->status;
		}


		$users = $this->ion_auth->users_limit( 1000, 0, 'pt' )->result();
		$user_select = array(
			'0' => 'Pilih' 
		);
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
			"name" => array(
			  'type' => 'text',
			  'label' => "Nama Pokmil",
			  'value' => $this->form_validation->set_value('name', $this->name),
			),
			"sk_no" => array(
				'type' => 'text',
				'label' => "Nomor SK Pokmil",
				'value' => $this->form_validation->set_value('sk_no', $this->sk_no),			  
			),
			"date" => array(
				'type' => 'date',
				'label' => "Tanggal SK Pokmil",
				'value' => $this->form_validation->set_value('date', $this->date),
			),
			"lead_id" => array(
				'type' => 'select',
				'label' => "Anggota 1",
				'options' => $user_select,
				'selected' => $this->lead_id,
			),
			"member_1_id" => array(
				'type' => 'select',
				'label' => "Anggota 2",
				'options' => $user_select,
				'selected' => $this->member_1_id,
			),
			"member_2_id" => array(
				'type' => 'select',
				'label' => "Anggota 3",
				'options' => $user_select,
				'selected' => $this->member_2_id,
			),
			"member_3_id" => array(
				'type' => 'select',
				'label' => "Anggota 4",
				'options' => $user_select,
				'selected' => $this->member_3_id,
			),
			"member_4_id" => array(
				'type' => 'select',
				'label' => "Anggota 5",
				'options' => $user_select,
				'selected' => $this->member_4_id,
			),
			// "status" => array(
			// 	'type' => 'select',
			// 	'label' => "Status",
			// 	'options' => array(
			// 		'Aktif' => 'Aktif',
			// 		'Non Aktif' => 'Non Aktif'
			// 	)
			// 	,
			// 	'selected' => $this->form_validation->set_value('status', $this->status),
			// ),
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
	  );
	  
	  return $config;
	}
}
?>
