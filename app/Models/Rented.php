<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rented extends Model
{
    use HasFactory;

    protected $table = 'renteds';
    protected $fillable = [
        'member_id',
        'book_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status'
    ];

    public function member()
    {
        return $this->belongsTo(Members::class, 'member_id');
    }

    public function book()
    {
        return $this->belongsTo(Books::class, 'book_id');
    }
}
