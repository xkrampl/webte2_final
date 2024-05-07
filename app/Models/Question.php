<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'description',
        'type',
        'is_active',
        'archive_note',
        'archived_at'
    ];

    public static function booted() {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::random(5);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['created_at'] ?? false, fn ($query, $value) => $query->where('created_at', '>=', $value))
            ->when($filters['subject'] ?? false, function ($query, $subject) {
                return $query->whereHas('subject', function ($query) use ($subject) {
                    $query->where('name', $subject);
                });
            });
    }
}
