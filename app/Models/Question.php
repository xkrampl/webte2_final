<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Question extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'subject_id',
        'archive_id',
        'description',
        'type',
        'is_active',
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

    public function archives(): BelongsToMany
    {
        return $this->belongsToMany(Archive::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['created_at'] ?? false,
                fn ($query, $value) => $query->whereDate('created_at', Carbon::parse($value)->toDateString())
            )
            ->when($filters['subject'] ?? false, function ($query, $subject) {
                return $query->whereHas('subject', function ($query) use ($subject) {
                    $query->where('name', $subject);
                });
            })
            ->when($filters['user'] ?? false, fn ($query, $user) => $query->where('user_id', $user))
            ->when($filters['archived'] ?? false, fn ($query, $value) => $query->whereNotNull('archive_id'));
    }
}
