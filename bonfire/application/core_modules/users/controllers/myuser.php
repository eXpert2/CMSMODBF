<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Myuser extends Admin_Controller {

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		$this->auth->restrict('Site.Settings.View');
		$this->auth->restrict('Bonfire.Users.View');

		$this->load->model('roles/role_model');

		Assets::add_js($this->load->view('myuser/users_js', null, true), 'inline');

		$this->lang->load('users');
	}

	//--------------------------------------------------------------------

	public function _remap($method)
	{
		if (method_exists($this, $method))
		{
			$this->$method();
		}
	}

	//--------------------------------------------------------------------

	public function index()
	{
		$offset = $this->uri->segment(4);

		$total_users = $this->user_model->count_all();

		$this->pager['base_url'] = site_url(SITE_AREA .'/myuser/users/index');
		$this->pager['total_rows'] = $total_users;
		$this->pager['per_page'] = $this->limit;
		$this->pager['uri_segment']	= 4;

		$this->pagination->initialize($this->pager);

		// Was a filter set?
		if ($this->input->post('filter_submit') && $this->input->post('filter_by_role_id'))
		{
			$role_id = $this->input->post('filter_by_role_id');

			$this->db->where('role_id', $role_id);
			Template::set('filter', $role_id);
		}

		Template::set('users', $this->user_model->limit($this->limit, $offset)->find_all());
		Template::set('total_users', $total_users);
		Template::set('deleted_users', $this->user_model->count_all(true));
		Template::set('roles', $this->role_model->select('role_id, role_name, default')->find_all());

		Template::set('user_count', $this->user_model->count_all());

		Template::set('login_attempts', $this->user_model->get_login_attempts($this->limit) );

		$this->load->helper('ui/ui');

		Template::set('toolbar_title', lang('us_user_management'));
		Template::render();
	}

	//--------------------------------------------------------------------

	public function create()
	{
		$this->auth->restrict('Bonfire.Users.Add');

		$this->load->config('address');
		$this->load->helper('address');

		if ($this->input->post('submit'))
		{
			if ($id = $this->save_user())
			{
				$user = $this->user_model->find($id);
				$this->activity_model->log_activity($this->auth->user_id(), lang('us_log_create').' '. $user->role_name . ': '.(config_item('auth.use_usernames') ? $user->username : $user->email), 'users');

				Template::set_message('User successfully created.', 'success');
				Template::redirect(SITE_AREA .'/myuser/users');
			}
			else
			{
				Template::set_message('There was a problem creating the user: '. $this->user_model->error);
			}
		}

		Template::set('roles', $this->role_model->select('role_id, role_name, default')->find_all());

		Template::set('toolbar_title', lang('us_create_user'));
		Template::set_view('myuser/user_form');
		Template::render();
	}

	//--------------------------------------------------------------------

	public function edit()
	{
		$this->auth->restrict('Bonfire.Users.Manage');

		$this->load->config('address');
		$this->load->helper('address');

		$user_id = $this->uri->segment(5);

		if ($this->input->post('submit'))
		{
			if ($this->save_user('update', $user_id))
			{
				$user = $this->user_model->find($user_id);

				$this->activity_model->log_activity($this->auth->user_id(), lang('us_log_edit') .': '.(config_item('auth.use_usernames') ? $user->username : $user->email), 'users');

				Template::set_message('User successfully updated.', 'success');
			}
			else
			{
				Template::set_message('There was a problem updating the user: '. $this->user_model->error);
			}
		}

		Template::set('user', $this->user_model->find($user_id));
		Template::set('roles', $this->role_model->select('role_id, role_name, default')->find_all());

		Template::set('toolbar_title', lang('us_edit_user'));
		Template::set_view('myuser/user_form');
		Template::render();
	}

	//--------------------------------------------------------------------

	public function delete()
	{
		$id = $this->uri->segment(5);

		if (!empty($id))
		{
			$this->auth->restrict('Bonfire.Users.Manage');

			if ($this->user_model->delete($id))
			{
				$user = $this->user_model->find($id);
				$this->activity_model->log_activity($this->auth->user_id(), lang('us_log_delete') . ': '.(config_item('auth.use_usernames') ? $user->username : $user->email), 'users');
				Template::set_message('The User was successfully deleted.', 'success');
			} else
			{
				Template::set_message('We could not delete the user: '. $this->user_model->error, 'success');
			}
		}

		redirect(SITE_AREA .'/myuser/users');
	}

	//--------------------------------------------------------------------

	public function deleted()
	{
		$this->db->where('deleted !=', 0);
		Template::set('users', $this->user_model->find_all(true));

		Template::render();
	}

	//--------------------------------------------------------------------

	public function purge()
	{
		$user_id = $this->uri->segment(5);

		// Handle a single-user purge
		if (!empty($user_id) && is_numeric($user_id))
		{
			$this->user_model->delete($user_id, true);
		}
		// Handle purging all deleted users...
		else
		{
			// Find all deleted accounts
			$users = $this->user_model->where('deleted', 1)
									  ->find_all(true);

			if (is_array($users))
			{
				foreach ($users as $user)
				{
					$this->user_model->delete($user->id, true);
				}
			}
		}

		Template::set_message('Users Purged.', 'success');

		redirect(SITE_AREA .'/myuser/users');
	}

	//--------------------------------------------------------------------

	public function restore()
	{
		$id = $this->uri->segment(5);

		if ($this->user_model->update($id, array('deleted'=>0)))
		{
			Template::set_message('User successfully restored.', 'success');
		}
		else
		{
			Template::set_message('Unable to restore user: '. $this->user_model->error, 'error');
		}

		redirect(SITE_AREA .'/myuser/users');
	}

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !HMVC METHODS
	//--------------------------------------------------------------------

	public function access_logs($limit=15)
	{
		$logs = $this->user_model->get_access_logs($limit);

		return $this->load->view('myuser/access_logs', array('access_logs' => $logs), true);
	}

	//--------------------------------------------------------------------



	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	public function unique_email($str)
	{
		if ($this->user_model->is_unique('email', $str))
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('unique_email', lang('us_email_in_use'));
			return false;
		}
	}

	//--------------------------------------------------------------------

	private function save_user($type='insert', $id=0)
	{
		$this->form_validation->set_rules('first_name', lang('us_first_name'), 'trim|strip_tags|max_length[20]|xss_clean');
		$this->form_validation->set_rules('last_name', lang('us_last_name'), 'trim|strip_tags|max_length[20]|xss_clean');
		if ($type == 'insert')
		{
			$this->form_validation->set_rules('email', 'Email', 'required|trim|callback_unique_email|valid_email|max_length[120]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required|trim|strip_tags|max_length[40]|xss_clean');
			$this->form_validation->set_rules('pass_confirm', 'Password (again)', 'required|trim|strip_tags|matches[password]|xss_clean');
		} else
		{
			$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|max_length[120]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|strip_tags|max_length[40]|xss_clean');
			$this->form_validation->set_rules('pass_confirm', 'Password (again)', 'trim|strip_tags|matches[password]|xss_clean');
		}
		if (config_item('auth.use_usernames'))
		{
			$this->form_validation->set_rules('username', 'Username', 'required|trim|strip_tags|max_length[30]|callback_unique_username|xsx_clean');
		}
		if  ( ! config_item('auth.use_extended_profile'))
		{
			$this->form_validation->set_rules('street1', 'Street 1', 'trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('street2', 'Street 2', 'trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('city', 'City', 'trim|strip_tags|xss_clean');
			$this->form_validation->set_rules('zipcode', 'Zipcode', 'trim|strip_tags|max_length[20]|xss_clean');
		}
		if ($this->form_validation->run() === false)
		{
			return false;
		}

		if ($type == 'insert')
		{
			return $this->user_model->insert($_POST);
		}
		else	// Update
		{
			return $this->user_model->update($id, $_POST);
		}
	}

	//--------------------------------------------------------------------


}

// End User Admin class