<?php
namespace App\Models;
use CodeIgniter\Model;

class PersonModel extends Model
{
    protected $table = 'person';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'last_name'];
}