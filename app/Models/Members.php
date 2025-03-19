<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    protected $table = 'members';
    protected $fillable = [
        'nama',
        'email',
        'alamat',
        'telepon'
    ];
    public function rented()
    {
        return $this->hasMany(Rented::class, 'member_id');
    }
}
