<?php

namespace App\Models;

use CodeIgniter\Model;

class RecordModel extends Model
{
    protected $table            = 'activities';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['user_id', 'title', 'description', 'status', 'created_at'];

    public function fetchUserItems(int $accountRef): array
    {
        return $this->where('user_id', $accountRef)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }
}
