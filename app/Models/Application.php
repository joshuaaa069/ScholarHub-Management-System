<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_code',
        'user_id',
        'scholarship_id',
        'officer_id',
        'status',
        'remarks',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}