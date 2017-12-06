<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property int $id
 * @property string $comment
 * @property int $post_id
 * @property int $user_id
 * @property int $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $comment_decrypted
 * @property-read \App\Post $post
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUserId($value)
 * @mixin \Eloquent
 * @property int $has_read
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereHasRead($value)
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
    
    protected $hidden = [
        'user'
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
    
    protected $appends = [
        'is_mine',
        'username'
    ];
    
    public function getIsMineAttribute()
    {
        if (!\Auth::check())
            return false;
        
        if ($this->user_id == \Auth::id())
            return true;
        
        return false;
    }
    
    public function getUsernameAttribute()
    {
        if ($this->user->matchRole([User::ROLE_ADMIN, User::ROLE_GOD])) {
            return $this->user->name;
        } else if ($this->user_id === $this->post->user_id) {
            return '作者';
        } else {
            return '未知';
        }
    }
}
