<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormAnswerModel extends Model
{
    protected $table = 'form_answer';
    protected $primaryKey = 'id';
    public $incrementing = false; // Use string IDs
    protected $keyType = 'string'; // Specify the key type as string
    protected $fillable = [
        'id',
        'area',
        'detail_area',
        'img_path',
        'kategori_temuan',
        'deskripsi',
        'potensi_bahaya',
        'masukan',
        'tingkat_prioritas',
        'pic',
        'img_path_repair',
        'deskripsi_repair',
        'status'
    ];
    public $timestamps = true; // Enable timestamps if needed
    protected $casts = [
        'id' => 'string',
        'area' => 'string',
        'detail_area' => 'string',
        'img_path' => 'string',
        'kategori_temuan' => 'string',
        'deskripsi' => 'string',
        'potensi_bahaya' => 'string',
        'masukan' => 'string',
        'tingkat_prioritas' => 'string',
        'pic' => 'string',
        'img_path_repair' => 'string',
        'deskripsi_repair' => 'string',
        'status' => 'string'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
