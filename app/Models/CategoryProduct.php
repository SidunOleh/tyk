<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Relations\Pivot;
use Mavinoo\Batch\Traits\HasBatch;
 
class CategoryProduct extends Pivot
{
    use HasBatch;
    
    protected $fillable = [
        'category_id',
        'product_id',
        'order',
    ];
}