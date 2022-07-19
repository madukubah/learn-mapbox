<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Public_Controller
{
        function __construct()
        {
                parent::__construct();
                $this->load->library( array( 'form_validation' ) ); 
                $this->load->helper('form');
                $this->config->load('ion_auth', TRUE);
                $this->load->helper(array('url', 'language'));
                $this->lang->load('auth');

                $this->load->library('services/Company_services');
		$this->services = new Company_services;

                $this->load->model(array(
			'company_model',
		));
        }

        public function login() 
        {
                // echo $this->config->item('identity', 'ion_auth') = "phone" ;return;
                $this->form_validation->set_rules('identity', 'identity', 'required');
                $this->form_validation->set_rules('user_password','user_password','trim|required');
                if ($this->form_validation->run() == true)
                {
                        // echo $this->input->post('identity');
                        // echo $this->input->post('user_password');
                        $identity_mode = ( is_numeric( $this->input->post('identity') ) ) ? "phone" : NULL;
                        // return;
                        if ( $this->ion_auth->login( $this->input->post('identity'), $this->input->post('user_password') , FALSE, $identity_mode  ))
                        {
                                //if the login is successful
                                //redirect them back to the home page
                                $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );

                                // echo $this->ion_auth->messages();return;

                                if( $this->ion_auth->is_admin()) redirect(site_url('/admin'));

                                if( $this->ion_auth->in_group( 'uadmin' ) ) redirect(site_url('/uadmin'));
                                if( $this->ion_auth->in_group( 'auditor' ) ) redirect(site_url('/auditor'));
                                if( $this->ion_auth->in_group( 'pjp' ) ) redirect(site_url('/pjp'));
                                if( $this->ion_auth->in_group( 'pa' ) ) redirect(site_url('/pa'));
                                if( $this->ion_auth->in_group( 'pt' ) ) redirect(site_url('/pt'));
                                if( $this->ion_auth->in_group( 'penyedia' ) ) redirect(site_url('/penyedia'));

                                redirect( site_url('/user') , 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                                // redirect( site_url('/uadmin') , 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                        }
                        else
                        {
                                // if the login was un-successful
                                // redirect them back to the login page
                                $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->ion_auth->errors() ) );

                                // echo $this->ion_auth->errors();return;

                                redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                        }
                }else{
                        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                        if(  validation_errors() || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
                        $this->render( "V_login_page" );
                }
        }
    
        public function register(  )
        {
                $tables = $this->config->item('tables', 'ion_auth');
                $identity_column = $this->config->item('identity', 'ion_auth');
                $this->form_validation->set_rules( $this->ion_auth->get_validation_config() );
                $this->form_validation->set_rules('phone', "No Telepon", 'trim|required');
                $this->form_validation->set_rules('password', "Password", 'trim|required');
                $this->form_validation->set_rules('email', "Email", 'trim|required|is_unique[users.email]');

                if ( $this->form_validation->run() === TRUE )
                {
                        $group_id = $this->input->post('group_id');

                        //   $email = $this->input->post('email') ;
                        //   $phone = $this->input->post('phone') ;
                        //   $identity = $phone ;
                        //   $password = $phone ;
                        $email = $this->input->post('email') ;
                        $identity = $email;
                        $password = $this->input->post('password');
                        // $password = substr( $email, 0, strpos( $identity, "@" ) ) ;


                        $additional_data = array(
                                'first_name' => $this->input->post('first_name'),
                                'last_name' => $this->input->post('last_name'),
                                'email' => $this->input->post('email'),
                                'phone' => $this->input->post('phone'),
                                'address' => $this->input->post('address'),
                        );
                }
                
                $identity_mode = NULL;
                
                if ($this->form_validation->run() === TRUE && ( $user_id =  $this->ion_auth->register($identity, $password, $email,$additional_data, [$group_id], $identity_mode ) ) )
                {       
                        $data['user_id'] = $user_id;
			$data['name'] = $this->input->post( 'name' );
			$data['company_type'] = $this->input->post( 'company_type' );
			$data['company_cert'] = $this->input->post( 'company_cert' );
			$data['npwp'] = $this->input->post( 'npwp' );
			$data['postal_code'] = $this->input->post( 'postal_code' );
			$data['province'] = $this->input->post( 'province' );
			$data['city'] = $this->input->post( 'city' );
			$data['website'] = $this->input->post( 'website' );
                        
                        $this->company_model->create( $data );
                        $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
                        redirect( site_url( 'penyedia'  )  );
                }
                else
                {
                        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                        if(  !empty( validation_errors() ) || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );

                        $alert = $this->session->flashdata('alert');
                        $this->data["key"] = $this->input->get('key', FALSE);
                        $this->data["alert"] = (isset($alert)) ? $alert : NULL ;
                        // $this->data["current_page"] = $this->current_page;
                        $this->data["block_header"] = "Daftar Penyedia";
                        $this->data["header"] = "Daftar Penyedia";
                        $this->data["sub_header"] = 'Klik Tombol Action Untuk Aksi Lebih Lanjut';

                        $form_data = $this->ion_auth->get_form_data();
                        $form_data['form_data']['group_id']['type'] = 'hidden' ;
                        $form_data['form_data']['group_id']['value'] = 9 ;
                        unset($form_data['form_data']['nrrp'] );
                        unset($form_data['form_data']['job_position'] );
                        unset($form_data['form_data']['sk_number'] );
                        unset($form_data['form_data']['due_date'] );
                        unset($form_data['form_data']['cert_no'] );
                        unset($form_data['form_data']['cert_date'] );
                        unset($form_data['form_data']['status'] );
                        $form_data['form_data']['password'] = array(
                                'type' => 'password',
                                'label' => "Password",
                        );
                        $form_data_company = $this->services->get_form_data();

                        $form_data = $this->load->view('templates/form/plain_form', $form_data , TRUE ) ;
                        $form_data_company = $this->load->view('templates/form/plain_form', $form_data_company , TRUE ) ;
                        $form_data .= $form_data_company;
                        $this->data[ "contents" ] =  $form_data;
                        
                        $this->render( "V_register" );
                }
        }

        public function register2() 
        {
                // return;
                $tables = $this->config->item('tables', 'ion_auth');
		$identity_column = $this->config->item('identity', 'ion_auth');
		$this->form_validation->set_rules( $this->ion_auth->get_validation_config() );
		$this->form_validation->set_rules('phone', "No Telepon", 'trim|required|is_unique[' . 'users' . '.' . $identity_column . ']');
		$this->form_validation->set_rules('password', "Kata Sandi", 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', "konfirmasi Kata Sandi", 'trim|required');
		if ($this->form_validation->run() === TRUE)
		{
                        $group_id = $this->input->post('group_id');
                        

			$email = strtolower( $this->input->post('email') );
			$identity = $this->input->post('phone');
			$password = $this->input->post('password');
			//$this->input->post('password');
                        // $group_id = array($group_id);

			$additional_data = array(
				'first_name' => $this->input->post('first_name'),
				'last_name' => $this->input->post('last_name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				// 'address' => $this->input->post('address')
			);
                }
                if ($this->form_validation->run() === TRUE && ( $user_id =  $this->ion_auth->register($identity, $password, $email,$additional_data, [$group_id], "phone" ) ) )
		{			
			// check to see if we are creating the user
			// redirect them back to the admin page
			
                        $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::SUCCESS, $this->ion_auth->messages() ) );
			redirect("auth/login", 'refresh');
		}
                else
                {
                        // $this->data = $this->ion_auth->get_form_data()["form_data"]; //harus paling pertama
                        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                        if(  ( validation_errors() ) || $this->ion_auth->errors() ) $this->session->set_flashdata('alert', $this->alert->set_alert( Alert::DANGER, $this->data['message'] ) );
                        $this->data['first_name']       = array(
                                'name' => 'first_name',
                                'placeholder' => 'Nama Depan',
                                'class' => 'form-control',
                                'value' => $this->form_validation->set_value('first_name')
                            );
                            $this->data['last_name']        = array(
                                'name' => 'last_name',
                                'id' => 'last_name',
                                'type' => 'text',
                                'placeholder' => 'Nama Belakang',
                                'class' => 'form-control',
                                'value' => $this->form_validation->set_value('last_name')
                            );
                            $this->data['identity']         = array(
                                'name' => 'identity',
                                'id' => 'identity',
                                'type' => 'text',
                                'value' => $this->form_validation->set_value('identity')
                            );
                            $this->data['email']            = array(
                                'name' => 'email',
                                'id' => 'email',
                                'type' => 'text',
                                'placeholder' => 'Email',
                                'class' => 'form-control',
                                'value' => $this->form_validation->set_value('email')
                            );
                            $this->data['phone']            = array(
                                'name' => 'phone',
                                'id' => 'phone',
                                'type' => 'text',
                                'placeholder' => 'Nomor HP',
                                'class' => 'form-control',
                                'value' => $this->form_validation->set_value('phone')
                            );
                            $groups =$this->ion_auth_model->groups(  )->result();
                            $group_select = array();
                                foreach( $groups as $group )
                                {
                                        if( $group->name == "admin" || $group->name == "uadmin" ) continue;
                                        $group_select[ $group->id ] = $group->description;
                                }
                            $this->data['group_id']            = array(
                                'name' => 'group_id',
                                'id' => 'group_id',
                                'type' => 'text',
                                'placeholder' => 'Group',
                                'class' => 'form-control',
                                'options' => $group_select,
                            );
                            $this->data['password']         = array(
                                'name' => 'password',
                                'id' => 'password',
                                'type' => 'password',
                                'placeholder' => 'Password',
                                'class' => 'form-control',
                                'value' => $this->form_validation->set_value('password')
                            );
                            $this->data['password_confirm'] = array(
                                'name' => 'password_confirm',
                                'id' => 'password_confirm',
                                'type' => 'password',
                                'placeholder' => 'Konfirmasi Password',
                                'class' => 'form-control',
                                'value' => $this->form_validation->set_value('password_confirm')
                            );
                        $this->render( "V_register_page" );
                }
        }

        public function logout()
        {
                $this->data['title'] = "Logout";

                // log the user out
                $logout = $this->ion_auth->logout();

                // redirect them to the login page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect(site_url(), 'refresh');
        }
}