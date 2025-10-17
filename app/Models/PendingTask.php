<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PendingTask extends Model
{

    use SoftDeletes;
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
        'rejected_reason',
        'rejected_by',
        'approved_by'
    ];

    public function document()
    {
        return $this->belongsTo(Documents::class, 'id_documents', 'id_documents');
    }
}
