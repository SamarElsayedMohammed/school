<?php

/**
 * User Model
 */
class User extends Model
{


    protected $allowedColumns = [
        'firstname',
        'lastname',
        'email',
        'password',
        'gender',
        'level',
        'date',
    ];

    protected $beforeInsert = [
        'make_user_id',
        'make_school_id',
        'hash_password'
    ];

    public function make_user_id($data)
    {
        $data['user_id'] = strtolower($data['firstname'] . "_" . $data['lastname']);

        while ($this->where('user_id', $data['user_id'])) {
            $data['user_id'] .= rand(10, 9999);
        }

        return $data;
    }

    public function make_school_id($data)
    {
        if (isset($_SESSION['USER']->school_id)) {
            $data['school_id'] = $_SESSION['USER']->school_id;
        } else {
            $data['school_id'] = '';
        }
        return $data;
    }

    public function hash_password($data)
    {
        // var_dump($data);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return $data;
    }
}
