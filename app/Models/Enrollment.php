<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'matriculas';

    protected $primaryKey = 'id_matricula';

    protected $fillable = ['id_user', 'id_especializacao', 'liberado', 'status', 'payment_type', 'purchase_date'];

    protected $dates = ['purchase_date'];


    /**
     * Get user relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Get course
     */
    public function course()
    {
        return $this->belongsTo(Course::class, 'id_especializacao', 'id_especializacao');
    }

    public function getIdAttribute()
    {
        return $this->id_matricula;
    }

    public function getDateAttribute()
    {
        return Carbon::parse($this->purchase_date)->format('Y-m-d');
    }

    public function getDateBrAttribute()
    {
        return Carbon::parse($this->purchase_date)->format('d/m/Y');
    }
}
