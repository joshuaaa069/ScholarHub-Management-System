<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_requirement_id',
        'student_file_path',
        'student_original_name',
        'student_uploaded_at',
        'registrar_file_path',
        'registrar_original_name',
        'registrar_uploaded_at',
        'registrar_uploader_id',
        'is_complete',
        'remarks',
    ];

    protected $casts = [
        'student_uploaded_at' => 'datetime',
        'registrar_uploaded_at' => 'datetime',
        'is_complete' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function requirement()
    {
        return $this->belongsTo(DocumentRequirement::class, 'document_requirement_id');
    }

    public function registrarUploader()
    {
        return $this->belongsTo(User::class, 'registrar_uploader_id');
    }
}
