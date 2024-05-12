<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot('quantity');
    }


    public function arttype()
    {
        return $this->belongsTo(ArtType::class);
    }

    protected $fillable = [
        'name',
        'description',
        'stock',
        'price',
        'image',
        'arttype_id', 
    ];
}
