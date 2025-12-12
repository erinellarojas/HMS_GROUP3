<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'email', 'password', 'role', 'created_at', 'updated_at'];

    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $deletedField = '';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[255]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[admin,teacher,student]'
    ];

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'This email address is already registered.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    protected $allowCallbacks = true;
    protected $beforeInsert = ['setDefaultRole'];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    protected function setDefaultRole(array $data)
    {
        if (empty($data['data']['role'])) {
            $data['data']['role'] = 'student';
        }
        return $data;
    }
}
