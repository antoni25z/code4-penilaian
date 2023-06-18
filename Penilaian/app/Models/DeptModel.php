<?php

namespace App\Models;

use CodeIgniter\Model;

class DeptModel extends Model
{
    protected $table = 'department';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id', 'dept_name'];
}