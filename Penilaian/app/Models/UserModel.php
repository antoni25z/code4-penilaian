<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id', 'username', 'password', 'type','fname', 'lname', 'email', 'sex', 'birth_place', 'birth_date', 'dept_id', 'address'];
}