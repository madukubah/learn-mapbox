<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Tender extends Penyedia_Controller {
	private $services = null;
    private $name = null;
    private $parent_page = 'penyedia';
	private $current_page = 'penyedia/tender/';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('services/Tender_services');
		$this->services = new Tender_services;

		$this->load->library('services/Draft_tender_services');
		$this->draft_tender_services = new Draft_tender_services;

		$this->load->model(array(
			'tender_model',
			'draft_tender_model',
			'tender_penyedia_model',
			'schedule_model',
			'comment_model',
		));
	}	

	public function index(  )
	{
		// 
		$page = ($this->uri->segment(4)) ? ($this->uri->segment(4) - 1) : 0;
		//pagination parameter
		$pagination['base_url'] = site_url( $this->current_page ) .'/index';
		$pagination['total_records'] = $this->tender_model->record_count() ;
		$pagination['limit_per_page'] = 10;
		$pagination['start_record'] = $page*$pagination['limit_per_page'];
		$pagination['uri_segment'] = 4;
		//set pagination
		if ($pagination['total_records']>0) $this->data['pagination_links'] = $this->setPagination($pagination);

		$table = $this->services->get_table_config( $this->current_page );
		unset($table['header']['start_date']);
		unset($table['header']['end_date']);
		unset($table['header']['status']);
		unset($table['header']['budget']);
		$table['header']['budget_estimation'] = 'HPS';
		$table['header']['announcement_start_date'] = 'Tanggal Mulai Tender';
		$table['header']['signing_end_date'] = 'Tanggal Selesai Tender';
		$table['header']['status'] = 'Status';
		unset($table['action'][2]);
		unset($table['action'][1]);
		if($this->input->get( 'search' )){
			$table[ "rows" ] = $this->tender_model
				->select('
					schedule.*,
					draft_tender.*,
					tender.*
				')
				->join(
					'schedule',
					'schedule.tender_id = tender.id',
					'inner'
				)
				->join(
					'draft_tender',
					'draft_tender.tender_id = tender.id',
					'inner'
				)
				->like('tender.'.$table["search"]["field"], $this->input->get( 'search' ))
				// ->where('status', 'Tayang')	
				->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		}
		else
		{
			$table[ "rows" ] = $this->tender_model
				->select('
					schedule.*,
					draft_tender.*,
					tender.*
				')
				->join(
					'schedule',
					'schedule.tender_id = tender.id',
					'inner'
				)
				->join(
					'draft_tender',
					'draft_tender.tender_id = tender.id',
					'inner'
				)
				->where('tender.status', 'Tayang')
				->tenders( $pagination['start_record'], $pagination['limit_per_page'] )->result();
		
		}
		
		$tables = [];
		for ($i=0; $i < count($table[ "rows" ]); $i++) { 
			$table[ "rows" ][$i]->year = $table[ "rows" ][$i]->year." ";
			if( $table[ "rows" ][$i]->file_download_end_date != '0000-00-00 00:00:00' )
			    $tables []= $table[ "rows" ][$i];
		}
		$table[ "rows" ] = $tables;
		foreach( $table[ "rows" ] as $row )
		{
			$row->id_enc = base64_encode($row->id);
		}
		$table = $this->load->view('templates/tables/plain_table', $table, true);
		$this->data[ "contents" ] = $table;

		#################################################################3
		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = "Tender";
		$this->data["header"] = "Tender";
		$this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';
		$this->render( "templates/contents/plain_content" );
	}

	public function register( $tender_id = NULL )
	{
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$user_id = $this->ion_auth->get_user_id();

		$tender_penyedia = $this->tender_penyedia_model
			->where('penyedia_id', $user_id )
			->where('tender_id', $tender_id )
			->tender_penyedia()
			->row();
		if( $tender_penyedia )
			redirect( site_url($this->current_page.'detail/'.$tender_id));

		$data['tender_id'] = $tender_id;
		$data['penyedia_id'] = $user_id;
		
		if( $this->tender_penyedia_model->create( $data ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_penyedia_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_penyedia_model->errors() ) );
		}
		redirect(site_url( $this->current_page.'detail/'.base64_encode($data['tender_id']) ));
	}

	public function effering_file( $tender_penyedia_id = NULL )
	{
		if ($tender_penyedia_id == NULL) redirect(site_url($this->current_page));
        
		$schedule = $this->schedule_model
			->where('tender_id', $this->input->post( 'tender_id' ))
			->schedule()
			->row();
		if( $schedule->effering_file_upload_end_date  !=  '0000-00-00 00:00:00' ){
		    $effering_file_upload_end_date = strtotime($schedule->effering_file_upload_end_date);
		    $time_now = time();
		    if( $time_now > $effering_file_upload_end_date )
		    {
		        $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, "Masa Upload Penawaran Sudah Selesai" ) );
		        redirect(site_url( $this->current_page.'detail/'.base64_encode($this->input->post( 'tender_id' )) ));   
		    }
		}
		$this->load->library('upload'); // Load librari upload
		
		$filename = "Penawaran_".time();
		$upload_path = 'uploads/tender/';
	
		$config['upload_path'] = './'.$upload_path;
		$config['image_path'] = base_url().$upload_path;
		$config['allowed_types'] = "pdf|docx";
		$config['overwrite']="true";
		$config['max_size']="2048";
		$config['file_name'] = ''.$filename;

		$this->upload->initialize($config);
		
		$data['tender_id'] = $this->input->post( 'tender_id' );
		$data_param["id"] = $tender_penyedia_id;

		if( isset($_FILES["effering_file"] ) ){
				
			if ( $this->upload->do_upload("effering_file") ) {
				$data['effering_file'] = $this->upload->data()["file_name"];

				$tender_penyedia = $this->tender_penyedia_model->tender_penyedia( $tender_penyedia_id )->row();
				if (!@unlink($config['upload_path'] . $tender_penyedia->effering_file )) { };
			}else {
				$this->session->set_flashdata('alert', $this->alert->set_alert(Alert::DANGER, $this->upload->display_errors()));
				redirect(site_url( $this->current_page.'detail/'.base64_encode($data['tender_id']) ));
			}
		}

		if( $this->tender_penyedia_model->update( $data, $data_param ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_penyedia_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_penyedia_model->errors() ) );
		}
		redirect(site_url( $this->current_page.'detail/'.base64_encode($data['tender_id']) ));
	}

	public function hps( $tender_penyedia_id = NULL )
	{
		if ($tender_penyedia_id == NULL) redirect(site_url($this->current_page));
        
		$data['tender_id'] = $this->input->post( 'tender_id' );
		$data['hps'] = $this->input->post( 'hps' );
		$data_param["id"] = $tender_penyedia_id;

		if( $this->tender_penyedia_model->update( $data, $data_param ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->tender_penyedia_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->tender_penyedia_model->errors() ) );
		}
		redirect(site_url( $this->current_page.'detail/'.base64_encode($data['tender_id']) ));
	}

	public function detail( $tender_id = null )
    {
		$tender_id = base64_decode($tender_id);
		$tender = $this->tender_model->tender( $tender_id )->row();
		if( ! $tender ) 
			redirect( site_url($this->current_page)  );
		if ($tender_id == NULL) redirect(site_url($this->current_page));
		$this->data['message'] = (validation_errors() ? validation_errors() : ($this->tender_model->errors() ? $this->tender_model->errors() : $this->session->flashdata('message')));
		if(  !empty( validation_errors() ) || $this->tender_model->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
		$tender = $this->tender_model->tender( $tender_id )->row();
		$this->data[ "tender" ] =  $tender;

		$alert = $this->session->flashdata('alert');
		$this->data["key"] = $this->input->get('key', FALSE);
		$this->data["alert"] = (isset($alert)) ? $alert : NULL ;
		$this->data["current_page"] = $this->current_page;
		$this->data["block_header"] = " ";
		$this->data["header"] = "Detail Tender Terumumkan ";
		$this->data["sub_header"] = '<div style="color:red">File yang diupload berekstensi .pdf, .docx</div>';

		$form_data = $this->services->get_form_data( $tender_id );
		unset($form_data['form_data']['budget']);
		unset($form_data['form_data']['start_date']);
		unset($form_data['form_data']['end_date']);
		$form_data = $this->load->view('templates/form/plain_form_readonly', $form_data , TRUE ) ;

		$draft_tender = $this->draft_tender_model
			->where('tender_id', $tender_id)
			->draft_tender()
			->row();
		$form_data_draft_tender = $this->draft_tender_services->get_form_data( $draft_tender->id );
		unset($form_data_draft_tender['form_data']['name']);
		unset($form_data_draft_tender['form_data']['status']);
		$form_data_draft_tender = $this->load->view('pt/paket/detail/plain_form_readonly', $form_data_draft_tender , TRUE ) ;

		$link_register_tender = 
		array(
			"name" => "Ikut Tender",
			"type" => "link",
			"url" => site_url( "penyedia/tender/register/".$tender_id),
			"button_color" => "success",	
			"data" => NULL,
		);

		$user_id = $this->ion_auth->get_user_id();
		$tender_penyedia = $this->tender_penyedia_model
			->where('penyedia_id', $user_id )
			->where('tender_id', $tender_id )
			->tender_penyedia()
			->row();
		if( !$tender_penyedia )
			$this->data[ "header_button" ] =  $this->load->view('templates/actions/link', $link_register_tender, TRUE );

		$tender_penyedia_table["header"] = array(
			'name' => 'Nama',
		);
		$tender_penyedia_table["number"] = 1;
		$tender_penyedia_table["rows"] = $this->tender_penyedia_model
			->select('	tender_penyedia.*, 
					company.name,
				')
			->where('tender_id', $tender_id )
			->join(
				"users",
				"users.id = tender_penyedia.penyedia_id",
				"inner")
			->join(
				"company",
				"company.user_id = users.id",
				"inner")
			->tender_penyedias()
			->result();
			
		$schedule = $this->schedule_model
			->where('tender_id', $tender_id)
			->schedule()
			->row();
		$tender_penyedia_table['user_id'] = $user_id;
		$tender_penyedia_table['schedule'] = $schedule;
		$tender_penyedia_table = $this->load->view('penyedia/tender/detail/plain_table', $tender_penyedia_table, true);
		$this->data[ "contents" ] =  $form_data.$form_data_draft_tender;
		$this->data[ "contents_2" ] =  $tender_penyedia_table;
		$schedule_id = '';
		$schedule_table = $this->load->view('penyedia/tender/detail/schedule_table', array('schedule' => $schedule,'tender_id' => $tender_id ), true);
		$this->data[ "contents_3" ] =  $schedule_table;

		$comments = $this->comment_model
			->select('
				comment.*,
				concat(users.first_name, " ", users.last_name) as user_name
			')
			->join(
				'users',
				'users.id = comment.user_id',
				'left'
			)
			->where('tender_id', $tender_id)
			->comments()
			->result();
		$this->data[ "comments" ] =  $comments;
		$this->render( "penyedia/tender/detail/content" );
	}

	public function comment( $tender_id )
	{
		$user_id = $this->ion_auth->get_user_id();

		$data['tender_id'] = $tender_id;
		$data['content'] = $this->input->post( 'content' );
		$data['user_id'] = $user_id;
		$data['datetime'] = date('Y-m-d H:i:s');
		

		if( $data['content'] == '' )
			redirect(site_url( $this->current_page.'detail/'.base64_encode($tender_id) ));

		if( $this->comment_model->create( $data ) ){
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->comment_model->messages() ) );
		}else{
			$this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->comment_model->errors() ) );
		}
		
		redirect(site_url( $this->current_page.'detail/'.base64_encode($tender_id) ));
	}

}
