<?php

namespace App\Models;

use CodeIgniter\Model;

class ResultRatingModel extends Model
{
    protected $table = 'result_rating';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['id', 'employee_id', 'month', 'year', 'result'];
}