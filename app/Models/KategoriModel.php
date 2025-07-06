<?php 

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'product_category'; 
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name','slug','description','is_active','created_at','updated_at'
    ];  
}