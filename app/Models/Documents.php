<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id_documents';
    protected $keyType = 'int';
    public $timestamps = true;
    public $incrementing = true;
    protected $fillable = [
        'type_document',
        'pic',
        'approval',
        'creating_task',
    ];

    // Relation to TypePeriod
    public function periods()
    {
        return $this->hasMany(TypePeriod::class, 'id_documents', 'id_documents');
    }

    // Return PIC as "Joao, Mario" in views
    public function getPicAttribute($value)
    {
        $arr = json_decode($value, true);
        return is_array($arr) ? implode(', ', $arr) : $value;
    }

    // Accept array or string when setting pic
    public function setPicAttribute($value)
    {
        $this->attributes['pic'] = is_array($value) ? json_encode(array_values($value)) : $value;
    }

    // Return Approval as "Joao, Mario" in views
    public function getApprovalAttribute($value)
    {
        $arr = json_decode($value, true);
        return is_array($arr) ? implode(', ', $arr) : $value;
    }

    // Accept array or string when setting approval
    public function setApprovalAttribute($value)
    {
        $this->attributes['approval'] = is_array($value) ? json_encode(array_values($value)) : $value;
    }

    // Optional: access raw arrays if you need them in code:
    public function getPicArrayAttribute()
    {
        $v = $this->attributes['pic'] ?? null;
        $arr = json_decode($v, true);
        return is_array($arr) ? $arr : [];
    }

    public function getApprovalArrayAttribute()
    {
        $v = $this->attributes['approval'] ?? null;
        $arr = json_decode($v, true);
        return is_array($arr) ? $arr : [];
    }
}
