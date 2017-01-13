<?php

class Logins_Controller extends Controller
{
	public function __construct($app)
	{
		parent::__construct($app);
		
		$this->app->get_page()->set_path(array(
			'index.php' => 'Index Page',
			'index.php?route=admin' => 'Admin Panel',
			'index.php?route='.MODULE_NAME => 'Login Page',
			));	
		
		$columns = array(
			array('db_name' => 'id',         'column_name' => 'Id',       'sorting' => 1),
			array('db_name' => 'agent',      'column_name' => 'Browser',    'sorting' => 1),
			array('db_name' => 'user_ip',    'column_name' => 'User IP', 'sorting' => 1),
			array('db_name' => 'user_id',    'column_name' => 'User ID',    'sorting' => 1),
			array('db_name' => 'login',      'column_name' => 'Login',    'sorting' => 1),
			array('db_name' => 'password',   'column_name' => 'Password',    'sorting' => 1),
			array('db_name' => 'login_time', 'column_name' => 'Login Date',     'sorting' => 1),
		);

		parent::init($columns);

		$layout = $this->app->get_settings()->get_config_key('page_template_admin');

		$this->app->get_page()->set_layout($layout);
	}

	public function Index_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::Index_Action();

			if (isset($_GET['mode'])) $_SESSION['logins_list_mode'] = $_GET['mode'];

			$options = array(
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&mode=1',
					'caption' => 'Login Succesful',
					'icon' => 'img/success.png',
					),
				array(
					'link' => 'index.php?route='.MODULE_NAME.'&mode=2',
					'caption' => 'Login Failed',
					'icon' => 'img/fail.png',
					),
				array(
					'link' => 'index.php?route=admin',
					'caption' => 'Cancel',
					'icon' => 'img/stop.png',
					),
				);

			$data = $this->app->get_model_object()->GetAll();

			parent::Update_Paginator();

			$this->app->get_page()->set_options($options);

			$this->app->get_page()->set_content($this->app->get_view_object()->ShowList($this->columns, $data));
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}

	public function View_Action()
	{
		if ($this->app->get_acl()->allowed(OPERATOR)) // są uprawnienia
		{
			parent::View_Action();

			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
			
			if (isset($_POST['cancel_button']))
			{
				header('Location: index.php?route='.MODULE_NAME);
				exit;
			}
			else // wczytany formularz
			{
				$options = array(
					array(
						'link' => 'index.php?route='.MODULE_NAME,
						'caption' => 'Cancel',
						'icon' => 'img/stop.png',
						),
					);

				$data = $this->app->get_model_object()->GetOne($id);

				$this->app->get_page()->set_options($options);

				$this->app->get_page()->set_content($this->app->get_view_object()->ShowDetails($data));
			}
		}
		else // brak uprawnień
		{
			parent::AccessDenied();
		}
	}
}

?>
