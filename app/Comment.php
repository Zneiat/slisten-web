<?php

namespace Slisten;

use Illuminate\Database\Eloquent\Model;

/**
 * Slisten\Comment
 *
 * @property int $id
 * @property string $comment
 * @property int $post_id
 * @property int $user_id
 * @property int $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $comment_decrypted
 * @property-read \Slisten\Post $post
 * @property-read \Slisten\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment whereUserId($value)
 * @mixin \Eloquent
 * @property int $has_read
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Comment whereHasRead($value)
 */
class Comment extends EncryptableModel
{
    protected $encryptable = [
        'comment',
    ];
    
    const TYPE_DEFAULT = 10;
    
    protected $attributes = [
        'has_read' => 0,
        'type'     => self::TYPE_DEFAULT,
    ];
    
    protected $fillable = [
        'comment',
        'post_id',
        'user_id',
        'type',
    ];
    
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function isHasRead()
    {
        if ($this->has_read === 1)
            return true;
        
        return false;
    }
    
    public function setHasRead($hasRead = true)
    {
        $hasRead = $hasRead ? 1 : 0;
        if ($this->has_read == $hasRead)
            return true;
        
        $this->has_read = $hasRead;
        return $this->save();
    }
}
