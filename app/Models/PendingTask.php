<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingTask extends Model
{
    protected $table = 'pending_task';
    protected $primaryKey = 'id_pending_task';

    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'id_documents',
        'upload',
        'periode_date',
        'status',
    ];

    public function document()
    {
        return $this->belongsTo(Documents::class, 'id_documents', 'id_documents');
    }
}
