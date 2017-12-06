<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Message
 *
 * @property-read \App\Comment $comment
 * @mixin \Eloquent
 * @property int $id
 * @property int $comment_id
 * @property int $from_user_id
 * @property int $to_user_id
 * @property int $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereFromUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereToUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Message whereUpdatedAt($value)
 */
class Message extends Model
{
    const TYPE_DEFAULT = 10;
    
    protected $attributes = [
        'type' => self::TYPE_DEFAULT,
    ];
    
    protected $fillable = [
        'comment_id',
        'from_user_id',
        'to_user_id',
        'type',
    ];
    
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
