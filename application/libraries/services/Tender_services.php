<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender_services
{
	protected $id;
	protected $code;
	protected $name;
	protected $type;
	protected $budget;
	protected $budget_source;
	protected $year;
	protected $location;
	protected $method;
	protected $start_date;
	protected $end_date;
	protected $status;
  
  function __construct()
  {
      $this->id		      	='';
      $this->code			='';
      $this->name			="";
      $this->type			="";
      $this->budget		  	="";
      $this->budget_source	="";
      $this->year		  	="";
      $this->location		= '';
	  $this->method			= '';
	  $this->start_date		='';
	  $this->end_date		='';
	  $this->status			='';
	  
  }

  public function __get($var)
  {
    return get_instance()->$var;
  }

  public function get_photo_upload_config( $name = "_" )
  {
    $filename = "PAKET_".time();
    $upload_path = 'uploads/tender/';

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
			'code' => 'Kode',
			'name' => 'Nama Paket',
			'type' => 'Jenis Pengadaan',
			'budget' => 'Anggaran',
			'year' => 'Tahun Anggaran',
			'start_date' => 'Mulai',
			'end_date' => 'Selesai',
			// 'physical_progress' => 'Progress Fisik (%)',
			// 'monetary_progress' => 'Progress Keuangan (%)',
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
	public function get_form_data( $tender_id = -1 )
	{
		if( $tender_id != -1 )
		{
			$tender 					= $this->tender_model->tender( $tender_id )->row();
			$this->id				=$tender->id;
			$this->code				=$tender->code;
			$this->name				=$tender->name;
			$this->type				=$tender->type;
			$this->budget			=$tender->budget;
			$this->budget_source	=$tender->budget_source;
			$this->year				=$tender->year;
			$this->location			=$tender->location;
			$this->method			=$tender->method;
			$this->start_date		=$tender->start_date;
			$this->end_date			=$tender->end_date;
			$this->status			=$tender->status;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			),
			"code" => array(
			  'type' => 'text',
			  'label' => "Kode Tender*",
			  'value' => $this->form_validation->set_value('code', $this->code),
			),
			"name" => array(
			  'type' => 'text',
			  'label' => "Nama Paket*",
			  'value' => $this->form_validation->set_value('name', $this->name),
			),
			"type" => array(
				'type' => 'select',
				'label' => "Jenis Pengadaan*",
				'options' => array(
					'Pengadaan Barang' => 'Pengadaan Barang',
					'Pekerjaan Konstruksi' => 'Pekerjaan Konstruksi',
				)
				,
				'selected' => $this->form_validation->set_value('type', $this->type),
			),
			"budget" => array(
			  'type' => 'text',
			  'label' => "Anggaran (Rp.)*",
			  'value' => $this->form_validation->set_value('budget', $this->budget),
			),
			"budget_source" => array(
			  'type' => 'text',
			  'label' => "Sumber Anggaran*",
			  'value' => $this->form_validation->set_value('budget_source', $this->budget_source),
			),
			"year" => array(
			  'type' => 'select',
			  'label' => "Tahun Anggaran*",
			  'options' => array(
					'2021' => '2021',
					'2022' => '2022',
					'2023' => '2023',
					'2024' => '2024',
					'2025' => '2025',
					'2026' => '2026',
					'2027' => '2027',
					'2028' => '2028',
					'2029' => '2029',
					'2030' => '2030',
				)
				,
				'selected' => $this->form_validation->set_value('year', $this->year),
			),
			"location" => array(
			  'type' => 'text',
			  'label' => "Lokasi*",
			  'value' => $this->form_validation->set_value('location', $this->location),
			),
			"method" => array(
				'type' => 'select',
				'label' => "Metode Pengadaan*",
				'options' => array(
					'Pengadaan Langsung' => 'Pengadaan Langsung',
					'Tender' => 'Tender',
				)
				,
				'selected' => $this->form_validation->set_value('method', $this->method),
			),
			"start_date" => array(
				'type' => 'date',
				'label' => "Tanggal Mulai Rencana Tender*",
				'value' => $this->form_validation->set_value('start_date', $this->start_date),
			),
			"end_date" => array(
				'type' => 'date',
				'label' => "Tanggal Selesai Rencana Tender*",
				'value' => $this->form_validation->set_value('end_date', $this->end_date),
			),
			"status" => array(
				'type' => 'select',
				'label' => "Status Tender*",
				'options' => array(
					'Rencana' => 'Rencana',
					'Tayang' => 'Tayang'
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
	  );
	  
	  return $config;
	}
}
?>
