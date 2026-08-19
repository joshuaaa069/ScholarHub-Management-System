<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'provider',
        'type',
        'benefits',
        'eligibility',
        'requirements',
        'slots_total',
        'slots_left',
        'min_gpa',
        'deadline',
        'status',
        'created_by',
    ];

    protected $casts = [
        'deadline' => 'date',
        'min_gpa' => 'float',
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function scholarshipAdmin()
    {
        return $this->hasOne(User::class, 'scholarship_id')
            ->where('role', 'Scholarship Admin');
    }
}
