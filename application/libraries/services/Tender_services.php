<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender_services
{
	protected $id;
	protected $name;
	protected $description;
	protected $start_date;
	protected $end_date;
	protected $latitude;
	protected $longitude;
  	protected $physical_progress;
  	protected $monetary_progress;
  	protected $image;
  
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
	  $this->image					='';
	  
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
			'code' => 'Kode Paket',
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
			$this->image			=$paket->image;
		}

		$_data["form_data"] = array(
			"id" => array(
				'type' => 'hidden',
				'label' => "ID",
				'value' => $this->form_validation->set_value('id', $this->id),
			),
			"code" => array(
			  'type' => 'text',
			  'label' => "Kode Tender",
			//   'value' => $this->form_validation->set_value('name', $this->name),
			  'value' => '',
			),
			"name" => array(
			  'type' => 'text',
			  'label' => "Nama Tender",
			  'value' => $this->form_validation->set_value('name', $this->name),
			),
			"type" => array(
				'type' => 'select',
				'label' => "Jenis Pengadaan",
				'options' => array(
					'Barang/Pekerjaan' => 'Barang/Pekerjaan',
					'Konstruksi/Jasa' => 'Konstruksi/Jasa',
					'Konsultansi/Jasa' => 'Konsultansi/Jasa',
					'Lainnya' => 'Lainnya',
				)
				,
				'selected' => '1',
			),
			"budget" => array(
			  'type' => 'number',
			  'label' => "Anggaran",
			//   'value' => $this->form_validation->set_value('name', $this->name),
			  'value' => '',
			),
			"budget_source" => array(
			  'type' => 'text',
			  'label' => "Sumber Dana",
			//   'value' => $this->form_validation->set_value('name', $this->name),
			  'value' => '',
			),
			"year" => array(
			  'type' => 'number',
			  'label' => "Tahun Anggaran",
			//   'value' => $this->form_validation->set_value('name', $this->name),
			  'value' => '',
			),
			"location" => array(
			  'type' => 'text',
			  'label' => "Lokasi",
			//   'value' => $this->form_validation->set_value('name', $this->name),
			  'value' => '',
			),
			"method" => array(
				'type' => 'select',
				'label' => "Metode Pengadaan",
				'options' => array(
					'Tender' => 'Tender',
					'Pengadaan Langsung' => 'Pengadaan Langsung',
				)
				,
				'selected' => '1',
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
			"status" => array(
				'type' => 'select',
				'label' => "Status",
				'options' => array(
					'Rencana' => 'Rencana',
					'Tayang' => 'Tayang'
				)
				,
				'selected' => '1',
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
		//   array(
		// 	'field' => 'summernote',
		// 	'label' => 'description',
		// 	'rules' =>  'trim|required',
		//   ),
	  );
	  
	  return $config;
	}
}
?>
