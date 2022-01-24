<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property int $parent_id
 * @property int $user_id
 * @property string $comment
 * @property User $user
 * @property Comment[]|Collection $replies
 */
class Comment extends Model
{
    use HasFactory;


    public $table = 'comments';

    protected $appends = ['picture', 'repliesCount'];

    protected $fillable = ['comment', 'parent_id', 'user_id'];

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function repliesCount(): int
    {
     return $this->replies->count();
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userPicture(): ?string
    {
        return $this->user->pictureUrl();
    }

    public function getPictureAttribute(): ?string
    {
        return $this->userPicture();
    }

    public function getFormattedDate(): string
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('H:i');
    }
}
