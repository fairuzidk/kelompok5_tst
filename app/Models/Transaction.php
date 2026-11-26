<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['judul', 'jumlah', 'catatan', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
