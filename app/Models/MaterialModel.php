<?php

namespace App\Models;

use CodeIgniter\Model;

class MaterialModel extends Model
{
    protected $table = 'materials';
    protected $primaryKey = 'id';
    protected $allowedFields = ['course_id', 'file_name', 'file_path', 'created_at'];
    protected $useTimestamps = false;

    public function insertMaterial($data)
    {
        return $this->insert($data);
    }

    public function getMaterialsByCourse($course_id)
    {
        return $this->where('course_id', $course_id)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getMaterialById($material_id)
    {
        return $this->find($material_id);
    }

    public function isDuplicateMaterial($course_id, $file_name)
    {
        return $this->where('course_id', $course_id)
                    ->where('file_name', $file_name)
                    ->first() !== null;
    }
}
