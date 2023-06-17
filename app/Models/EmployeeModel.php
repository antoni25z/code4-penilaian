<?php

namespace App\Models;

use CodeIgniter\Model;

class EmployeeModel extends Model
{
    protected $table = 'employee';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['id', 'fname', 'lname', 'email', 'sex', 'birth_place', 'birth_date', 'join_date', 'dept_id', 'address', 'promoted'];
}