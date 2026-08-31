<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    /**
     * Two-stage workflow status values:
     *  - Pending              : submitted by student, awaiting registrar
     *  - Registrar Approved   : registrar endorsed; awaits scholarship admin final decision
     *  - Registrar Rejected   : registrar disqualified the application
     *  - Approved             : scholarship admin accepted the scholar
     *  - Rejected             : scholarship admin denied the scholar
     *  - Needs Revision       : sent back to the student for updates (optional stage)
     */
    public const STATUS_PENDING = 'Pending';
    public const STATUS_REGISTRAR_APPROVED = 'Registrar Approved';
    public const STATUS_REGISTRAR_REJECTED = 'Registrar Rejected';
    public const STATUS_APPROVED = 'Approved';
    public const STATUS_REJECTED = 'Rejected';
    public const STATUS_NEEDS_REVISION = 'Needs Revision';

    protected $fillable = [
        'application_code',
        'user_id',
        'scholarship_id',
        'officer_id',
        'registrar_id',
        'status',
        'registrar_remarks',
        'admin_remarks',
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

    public function registrar()
    {
        return $this->belongsTo(User::class, 'registrar_id');
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    /**
     * Statuses that the registrar can act on.
     */
    public static function registrarActionableStatuses(): array
    {
        return [self::STATUS_PENDING];
    }

    /**
     * Statuses that the scholarship admin can act on.
     */
    public static function adminActionableStatuses(): array
    {
        return [self::STATUS_REGISTRAR_APPROVED];
    }

    /**
     * Human-friendly stage label for the given status.
     */
    public static function stageLabel(?string $status): string
    {
        return match ($status) {
            self::STATUS_PENDING => 'Awaiting Registrar Review',
            self::STATUS_REGISTRAR_APPROVED => 'Awaiting Scholarship Admin Decision',
            self::STATUS_REGISTRAR_REJECTED => 'Disqualified by Registrar',
            self::STATUS_APPROVED => 'Accepted as Scholar',
            self::STATUS_REJECTED => 'Rejected',
            self::STATUS_NEEDS_REVISION => 'Needs Revision',
            default => $status ?? 'Unknown',
        };
    }
}
