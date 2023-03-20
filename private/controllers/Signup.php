<?php

/**
 * login controller
 */
class Signup extends Controller
{

	function index()
	{
		// code...
		$mode = isset($_GET['mode']) ? $_GET['mode'] : '';
		$errors = array();
		if (count($_POST) > 0) {
			$user = new User();
			$fields = [
				'firstname' => 'required|min:4| max:255',
				'lastname' => 'required, max: 255',
				'email' => 'email|exists:User',
				'gender' => 'required|exists_in_array:["female", "male","other"]',
				'level' => 'required | exists_in_array:["student", "reception", "lecturer", "admin", "super_admin"]',
				'password' => 'required | secure',
				'password2' => 'required | same:password'
			];

			$errors = validate(
				$_POST,
				$fields,
				[
					'required' => 'The %s is required <hr>',
					'exists' => 'this %s is already exists befotre <hr>',
					'exists_in_array' => 'the %s is not in selction array <hr>',
					'password2' => ['same' => 'Please enter the same password again <hr>'],

				]
			);
			if (empty($errors)) {
				$_POST['date'] = date("Y-m-d H:i:s");
				$user->insert($_POST);
				$redirect = $mode == 'students' ? 'students':'users';
				$this->redirect('users');
			}
		}
		$this->view('signup', [
			'errors' => $errors,
			'mode'=>$mode,
		]);
	}
}
