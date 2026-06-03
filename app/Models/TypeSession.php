<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TypeSession extends Model
{
    protected $table = 'type_sessions';

    protected $fillable = [
        'idSession',
        'type',        // 'Code', 'Créneau', 'Conduite'
        'description',
    ];

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (TypeSession $typeSession) {
            if (empty($typeSession->idSession)) {
                $typeSession->idSession = Str::uuid()->toString();
            }
        });
    }

    public function sessions()
    {
        return $this->hasMany(SessionFormation::class);
    }

    // Label lisible
    public function getLabelAttribute(): string
    {
        return match($this->type) {
            'code'     => '📋 Code',
            'creneau'  => '🔧 Créneau',
            'conduite' => '🚗 Conduite',
            default    => $this->type,
        };
    }
}