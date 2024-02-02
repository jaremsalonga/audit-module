<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLogModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'name',
        'email',
        'response'
    ];

    protected $table = 'audit_log';
}
