<?php

/**
 * login controller
 */
class Login extends Controller
{

	function index()
	{
		// code...
		$errors = array();

		if (count($_POST) > 0) {

			$user = new User();
			if ($row = $user->where('email', $_POST['email'])) {
				$row = $row[0];
				if (password_verify($_POST['password'], $row->password)) {
					// var_dump($row->password);

					$school = new School();
 					$school_row = $school->first('school_id',$row->school_id);
 					$row->school_name = $school_row->school;
 					

					Auth::authenticate($row);
					// var_dump($_SESSION['USER']);
					$this->redirect('/home');
				} else {
					$errors['email'] = "Wrong  password";
				}
			} else {

				$errors['email'] = "Wrong email or password";
			}
		}
		$this->view('login', [
			'errors' => $errors,
		]);
	}
}
