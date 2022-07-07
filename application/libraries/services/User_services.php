<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User_services
{
  // user var
	protected $id;
	protected $identity;
	protected $first_name;
	protected $last_name;
	protected $phone;
	protected $address;
	protected $email;
  	protected $group_id;

  	protected $nrrp;
  	protected $job_position;
  	protected $sk_number;
  	protected $due_date;
  	protected $cert_no;
  	protected $cert_date;
  	protected $status;
  
  function __construct()
  {
      $this->id		      	='';
      $this->identity		='';
      $this->first_name		="";
      $this->last_name		="";
      $this->phone		  	="";
      $this->address		="";
      $this->email		  	="";
      $this->group_id		= '';

      $this->nrrp			= '';
      $this->job_position	= '';
      $this->sk_number		= '';
      $this->due_date		= '';
      $this->cert_no		= '';
      $this->cert_date		= '';
      $this->status			= '';
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
			'username' => 'username',
			'group_name' => 'Group',
			'user_fullname' => 'Nama Lengkap',
			'phone' => 'No Telepon',
			'address' => 'Alamat',
			'email' => 'Email',
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
			  "modal_id" => "delete_category_",
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
			  "title" => "User",
			  "data_name" => "user_fullname",
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
	public function get_form_data_readonly( $user_id = -1 )
	{
		if( $user_id != -1 )
		{
			$user 				= $this->ion_auth_model->user( $user_id )->row();
			$this->identity		=$user->username;
			$this->first_name	=$user->first_name;
			$this->last_name	=$user->last_name;
			$this->phone		=$user->phone;
			$this->id			=$user->user_id;
			$this->email		=$user->email;
			$this->group_id		=$user->group_id;
			$this->address		=$user->address;

			$this->nrrp			=$user->nrrp;
			$this->job_position	=$user->job_position;
			$this->sk_number	=$user->sk_number;
			$this->due_date		=$user->due_date;
			$this->cert_no		=$user->cert_no;
			$this->cert_date	=$user->cert_date;
			$this->status		=$user->status;

		}

		$groups =$this->ion_auth_model->groups(  )->result();
		$group_select = array();
		foreach( $groups as $group )
		{
			// if( $group->id == 1 ) continue;
			$group_select[ $group->id ] = $group->name;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			),
			"first_name" => array(
			  'type' => 'text',
			  'label' => "Nama Depan",
			  'value' => $this->form_validation->set_value('first_name', $this->first_name),
			),
			"last_name" => array(
			  'type' => 'text',
			  'label' => "Nama Belakang",
			  'value' => $this->form_validation->set_value('last_name', $this->last_name),
			  
			),
			"email" => array(
			  'type' => 'text',
			  'label' => "Email",
			  'value' => $this->form_validation->set_value('email', $this->email),			  
			),
			"phone" => array(
			  'type' => 'number',
			  'label' => "Nomor Telepon",
			  'value' => $this->form_validation->set_value('phone', $this->phone),			  
			),
			"address" => array(
				'type' => 'text',
				'label' => "Alamat",
				'value' => $this->form_validation->set_value('address', $this->address),			  
			),
			"nrrp" => array(
				'type' => 'text',
				'label' => "NRRP",
				'value' => $this->form_validation->set_value('nrrp', $this->nrrp),			  
			),
			"job_position" => array(
				'type' => 'text',
				'label' => "Jabatan",
				'value' => $this->form_validation->set_value('job_position', $this->job_position),			  
			),
			"sk_number" => array(
				'type' => 'text',
				'label' => "Nomor SK Pengangkatan",
				'value' => $this->form_validation->set_value('sk_number', $this->sk_number),			  
			),
			"due_date" => array(
				'type' => 'date',
				'label' => "Masa Berlaku",
				'value' => $this->form_validation->set_value('due_date', $this->due_date),			  
			),
			"cert_no" => array(
				'type' => 'text',
				'label' => "Nomor Sertifikat Pengadaan/Barang Jasa",
				'value' => $this->form_validation->set_value('cert_no', $this->cert_no),			  
			),
			"cert_date" => array(
				'type' => 'date',
				'label' => "Tanggal Sertifikat",
				'value' => $this->form_validation->set_value('cert_date', $this->cert_date),			  
			),
			"status" => array(
				'type' => 'select',
				'label' => "Status",
				'options' => array(
					'Aktif' => 'Aktif',
					'Non Aktif' => 'Non Aktif'
				)
				,
				'selected' => $this->status,
			),
			"group_id" => array(
				'type' => 'select',
				'label' => "User Group",
				'options' => $group_select,
				'selected' => $this->group_id,
			),
		  );
		return $_data;
	}
}
?>
