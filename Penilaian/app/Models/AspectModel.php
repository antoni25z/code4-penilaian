<?php

namespace App\Models;

use CodeIgniter\Model;

class AspectModel extends Model
{
    protected $table = 'aspect';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id', 'name', 'core_weight', 'secondary_weight', 'weight'];
}