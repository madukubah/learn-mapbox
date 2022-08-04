<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Company_services
{
	protected $id;
	protected $user_id;
	protected $name;
	protected $company_type;
	protected $company_cert;
	protected $npwp;
	protected $postal_code;
	protected $province;
	protected $city;
	protected $website;
  
  function __construct()
  {
      $this->id		      		='';
      $this->user_id		    ='';
      $this->name				='';
      $this->company_type		="";
      $this->company_cert		="";
      $this->npwp				="";
      $this->postal_code		="";
      $this->province			="";
      $this->city				= '';
	  $this->website			='';
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

  public function get_tax_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Nama Pajak',
        'date' => 'Tanggal',
        'cert_no' => 'Nomor Bukti',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_tax_",
                "url" => $_page,
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
						'type' => 'hidden',
						'label' => "ID",
					),
					"company_id" => array(
						'type' => 'hidden',
						'label' => "company_id",
					),
					"name" => array(
						'type' => 'text',
						'label' => "Nama Pajak",
					),
					"date" => array(
						'type' => 'date',
						'label' => "Tanggal",
					),
					"cert_no" => array(
						'type' => 'text',
						'label' => "Nomor Bukti",
					),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_tax_",
                "url" => $_page,
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
				  "delete" => array(
                    'type' => 'hidden',
                    'label' => "delete",
                    'value' => true,
                  ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }

  public function get_experience_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Nama Pekerjaan',
        'location' => 'Lokasi',
        'agency' => 'Instansi',
        'address' => 'Alamat',
        'start_date' => 'Tanggal Kontrak',
        'end_date' => 'Selesai Kontrak',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_experience_",
                "url" => $_page,
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
						'type' => 'hidden',
						'label' => "ID",
					),
					"company_id" => array(
						'type' => 'hidden',
						'label' => "company_id",
					),
					"name" => array(
						'type' => 'text',
						'label' => "Nama Pekerjaan",
					),
					"location" => array(
						'type' => 'text',
						'label' => "Lokasi",
					),
					"agency" => array(
						'type' => 'text',
						'label' => "Instansi",
					),
					"address" => array(
						'type' => 'text',
						'label' => "Alamat",
					),
					"start_date" => array(
						'type' => 'date',
						'label' => "Tanggal Kontrak",
					),
					"end_date" => array(
						'type' => 'date',
						'label' => "Selesai Kontrak",
					),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_experience_",
                "url" => $_page,
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
				  "delete" => array(
                    'type' => 'hidden',
                    'label' => "delete",
                    'value' => true,
                  ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }

  public function get_tool_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Nama Alat',
        'quantity' => 'Jumlah',
        'capacity' => 'Kapasitas',
        'type' => 'Merk',
        'condition' => 'Kondisi',
        'year' => 'Tahun Pembuatan',
        'location' => 'Lokasi Sekarang',
        'cert_no' => 'Bukti Kepemilikan',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_tool_",
                "url" => $_page,
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
						'type' => 'hidden',
						'label' => "ID",
					),
					"company_id" => array(
						'type' => 'hidden',
						'label' => "company_id",
					),
					"name" => array(
						'type' => 'text',
						'label' => "Nama Alat",
					),
					"quantity" => array(
						'type' => 'number',
						'label' => "Jumlah",
					),
					"capacity" => array(
						'type' => 'number',
						'label' => "Kapasitas",
					),
					"type" => array(
						'type' => 'text',
						'label' => "Merk/Tipe",
					),
					"condition" => array(
						'type' => 'text',
						'label' => "Kondisi",
					),
					"year" => array(
						'type' => 'number',
						'label' => "Tahun Pembuatan",
					),
					"location" => array(
						'type' => 'text',
						'label' => "Lokasi Sekarang",
					),
					"cert_no" => array(
						'type' => 'text',
						'label' => "Bukti Kepemilikan (Nomor)",
					),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_tool_",
                "url" => $_page,
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
				  "delete" => array(
                    'type' => 'hidden',
                    'label' => "delete",
                    'value' => true,
                  ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }

  public function get_expert_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Nama',
        'birthday' => 'Tanggal Lahir',
        'address' => 'Alamat',
        'last_study' => 'Pendidikan Terakhir',
        'email' => 'Email',
        'experience' => 'Pengalaman Kerja',
        'skill' => 'Profesi',
        'npwp' => 'NPWP',
        'sex' => 'L/P',
        'nationality' => 'Kewarganegaraan',
        'status' => 'Status',
        'position' => 'Jabatan',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_expert_",
                "url" => $_page,
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
						'type' => 'hidden',
						'label' => "ID",
					),
					"company_id" => array(
						'type' => 'hidden',
						'label' => "company_id",
					),
					"name" => array(
						'type' => 'text',
						'label' => "Nama",
					),
					"birthday" => array(
						'type' => 'date',
						'label' => "Tanggal Lahir",
					),
					"address" => array(
						'type' => 'text',
						'label' => "Alamat",
					),
					"last_study" => array(
						'type' => 'text',
						'label' => "Pendidikan Terakhir",
					),
					"email" => array(
						'type' => 'text',
						'label' => "Email",
					),
					"experience" => array(
						'type' => 'text',
						'label' => "Pengalaman Kerja (Tahun)",
					),
					"skill" => array(
						'type' => 'text',
						'label' => "Profesi/Keahlian",
					),
					"npwp" => array(
						'type' => 'number',
						'label' => "NPWP",
					),
					"sex" => array(
						'type' => 'select',
						'label' => "Jenis Kelamin",
						'options' => array(
							'Laki Laki' => 'Laki Laki',
							'Perempuan' => 'Perempuan'
						),
					),
					"nationality" => array(
						'type' => 'text',
						'label' => "Kewarganegaraan",
					),
					"status" => array(
						'type' => 'select',
						'label' => "Status",
						'options' => array(
							'Tetap' => 'Tetap',
							'Tidak Tetap' => 'Tidak Tetap'
						),
					),
					"position" => array(
						'type' => 'text',
						'label' => "Jabatan",
					),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_expert_",
                "url" => $_page,
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
				  "delete" => array(
                    'type' => 'hidden',
                    'label' => "delete",
                    'value' => true,
                  ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }
  
  public function get_ownership_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Nama',
        'id_number' => 'Nomor KTP',
        'address' => 'address',
        'shared' => 'Saham',
        'unit' => 'Satuan(Lembar/Persen)',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_ownership_",
                "url" => $_page,
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
						'type' => 'hidden',
						'label' => "ID",
					),
					"company_id" => array(
						'type' => 'hidden',
						'label' => "company_id",
					),
					"name" => array(
						'type' => 'text',
						'label' => "Nama",
					),
					"id_number" => array(
						'type' => 'number',
						'label' => "Nomor KTP",
					),
					"address" => array(
						'type' => 'text',
						'label' => "Alamat",
					),
					"shared" => array(
						'type' => 'text',
						'label' => "Saham",
					),
					"unit" => array(
						'type' => 'text',
						'label' => "Satuan(Lembar/Persen)",
					),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_ownership_",
                "url" => $_page,
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
				  "delete" => array(
                    'type' => 'hidden',
                    'label' => "delete",
                    'value' => true,
                  ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }

  public function get_acta_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Nomor',
        'date' => 'Tanggal Surat',
        'notary' => 'Notaris',
        'desc' => 'Keterangan',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_acta_",
                "url" => $_page,
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
						'type' => 'hidden',
						'label' => "ID",
					),
					"company_id" => array(
						'type' => 'hidden',
						'label' => "company_id",
					),
					"name" => array(
						'type' => 'text',
						'label' => "Nomor",
					),
					"date" => array(
						'type' => 'date',
						'label' => "Tanggal Surat",
					),
					"notary" => array(
						'type' => 'text',
						'label' => "Notaris",
					),
					"desc" => array(
						'type' => 'text',
						'label' => "Keterangan",
					),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_acta_",
                "url" => $_page,
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
				  "delete" => array(
                    'type' => 'hidden',
                    'label' => "delete",
                    'value' => true,
                  ),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
    );
    return $table;
  }

  public function get_company_permission_table_config( $_page, $start_number = 1 )
  {
      $table["header"] = array(
        'name' => 'Nama Ijin',
        'cert_no' => 'Nomor Surat',
        'agency_from' => 'Instansi Pemberi',
        'qualification' => 'Kualifikasi',
      );
      $table["number"] = $start_number;
      $table[ "action" ] = array(
              array(
                "name" => 'Edit',
                "type" => "modal_form",
                "modal_id" => "edit_permission_",
                "url" => $_page,
                "button_color" => "primary",
                "param" => "id",
                "form_data" => array(
                    "id" => array(
						'type' => 'hidden',
						'label' => "ID",
					),
					"company_id" => array(
						'type' => 'hidden',
						'label' => "company_id",
					),
					"name" => array(
						'type' => 'text',
						'label' => "Nama Ijin",
					),
					"cert_no" => array(
						'type' => 'text',
						'label' => "Nomor Surat",
					),
					"agency_from" => array(
						'type' => 'text',
						'label' => "Instansi Pemberi",
					),
					"qualification" => array(
						'type' => 'select',
						'label' => "Kualifikasi",
						'options' => array(
							'Kecil' => 'Kecil',
							'Menengah' => 'Menengah',
							'Besar' => 'Besar',
						),
					),
                ),
                "title" => "Group",
                "data_name" => "name",
              ),
              array(
                "name" => 'X',
                "type" => "modal_delete",
                "modal_id" => "delete_permission_",
                "url" => $_page,
                "button_color" => "danger",
                "param" => "id",
                "form_data" => array(
                  "id" => array(
                    'type' => 'hidden',
                    'label' => "id",
                  ),
				  "delete" => array(
                    'type' => 'hidden',
                    'label' => "delete",
                    'value' => true,
                  ),
                ),
                "title" => "",
                "data_name" => "name",
              ),
    );
    return $table;
  }

  public function get_table_config( $_page, $start_number = 1 )
  {
	// sesuaikan nama tabel header yang akan d tampilkan dengan nama atribut dari tabel yang ada dalam database
    $table["header"] = array(
			'name' => 'Nama',
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
	public function get_form_data( $company_id = -1 )
	{
		if( $company_id != -1 )
		{
			$company 					= $this->company_model->company( $company_id )->row();
			$this->id					=$company->id;
			$this->user_id				=$company->user_id;
			$this->name					=$company->name;
			$this->company_type			=$company->company_type;
			$this->company_cert			=$company->company_cert;
			$this->npwp					=$company->npwp;
			$this->postal_code			=$company->postal_code;
			$this->province				=$company->province;
			$this->city					=$company->city;
			$this->website				=$company->website;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			),
			"user_id" => array(
				'type' => 'hidden',
				'label' => "user_id",
				'value' => $this->form_validation->set_value('user_id', $this->user_id),
			),
			"name" => array(
			  'type' => 'text',
			  'label' => "Nama Usaha",
			  'value' => $this->form_validation->set_value('name', $this->name),
			),
			"company_type" => array(
				'type' => 'select',
				'label' => "Bentuk Usaha",
				'options' => array(
					'CV' => 'CV',
					'Firma' => 'Firma',
					'Koperasi' => 'Koperasi',
					'Lembaga Penyiaran Publik' => 'Lembaga Penyiaran Publik',
					'PT' => 'PT',
					'Perseroan' => 'Perseroan',
					'Perseroan Daerah' => 'Perseroan Daerah',
					'Perusahaan Asing/Foreign Vendor' => 'Perusahaan Asing/Foreign Vendor',
					'Perusahaan Dagang' => 'Perusahaan Dagang',
					'Perusahaan Umum' => 'Perusahaan Umum',
					'Perusahaan Umum Daerah' => 'Perusahaan Umum Daerah',
					'Usaha Dagang' => 'Usaha Dagang',
					'Usaha Perorangan' => 'Usaha Perorangan',
				)
				,
				'selected' => $this->form_validation->set_value('company_type', $this->company_type),
			),
			"company_cert" => array(
				'type' => 'text',
				'label' => "Nomor Induk Berusaha (NIB)",
				'value' => $this->form_validation->set_value('company_cert', $this->company_cert),			  
			),
			"npwp" => array(
				'type' => 'text',
				'label' => "NPWP",
				'value' => $this->form_validation->set_value('npwp', $this->npwp),			  
			),
			"postal_code" => array(
				'type' => 'text',
				'label' => "Kode Pos",
				'value' => $this->form_validation->set_value('postal_code', $this->postal_code),			  
			),
			"province" => array(
				'type' => 'select',
				'label' => "Provinsi",
				'value' => $this->form_validation->set_value('province', $this->province),			  
			),
			"city" => array(
				'type' => 'select',
				'label' => "Kabupaten/Kota",
				'value' => $this->form_validation->set_value('city', $this->city),			  
			),
			"website" => array(
				'type' => 'text',
				'label' => "Website",
				'value' => $this->form_validation->set_value('website', $this->website),			  
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
	  );
	  
	  return $config;
	}
}
?>
