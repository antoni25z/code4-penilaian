<?php

namespace App\Models;

use CodeIgniter\Model;

class CriteriaModel extends Model
{
    protected $table = 'criteria';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id', 'name', 'type', 'target', 'aspect_id', 'dept_id'];
}