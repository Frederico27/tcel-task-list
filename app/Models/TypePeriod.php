<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePeriod extends Model
{
    protected $table = 'documents_period';
    protected $primaryKey = 'id_docu_period';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = ['id_documents', 'period_type', 'period_value'];

    protected $casts = [
        'period_value' => 'array'
    ];

    //relation to Documents
    public function document()
    {
        return $this->belongsTo(Documents::class, 'id_documents', 'id_documents');
    }

    // Return period_value as "val1, val2" in views if stored as JSON/array
    public function getPeriodValueAttribute($value)
    {
        $arr = json_decode($value, true);
        return is_array($arr) ? implode(', ', $arr) : $value;
    }

    // Accept array or string when setting period_value
    public function setPeriodValueAttribute($value)
    {
        $this->attributes['period_value'] = is_array($value) ? json_encode(array_values($value)) : $value;
    }
}
