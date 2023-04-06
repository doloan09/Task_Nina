<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Class_HP extends Model
{
    use HasFactory;

    protected $table = 'classes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name_class',
        'code_class',
        'id_subject',
        'id_semester',
    ];

}
