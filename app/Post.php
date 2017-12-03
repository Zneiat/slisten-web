<?php

namespace Slisten;

use Illuminate\Database\Eloquent\Model;

/**
 * Slisten\Post
 *
 * @property int $id
 * @property string $content
 * @property string $sign
 * @property int $user_id
 * @property int $status
 * @property int $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Slisten\Comment[] $comments
 * @property-read mixed $content_decrypted
 * @property-read \Slisten\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereUserId($value)
 * @mixin \Eloquent
 * @property int $admin_has_read
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Post whereAdminHasRead($value)
 */
class Post extends Model
{
    const STATUS_DEFAULT = 10;
    const TYPE_DEFAULT = 10;
    
    protected $attributes = [
        'sign'           => '',
        'admin_has_read' => 0,
        'status'         => self::STATUS_DEFAULT,
        'type'           => self::TYPE_DEFAULT,
    ];
    
    protected $fillable = [
        'content',
        'sign',
        'user_id',
        'user_id',
        'status',
        'type',
    ];
    
    /*public function status()
    {
        return $this->belongsTo(Status::class);
    }*/
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function getContentDecryptedAttribute()
    {
        try {
            return decrypt($this->content);
        } catch (\Exception $e) {
            return $this->content;
        }
    }
    
    public function getFullSign()
    {
        $fullSign = '';
        if (!empty(trim($this->sign)))
            $fullSign .= $this->sign . ' · ';
        $fullSign .= $this->created_at->toDateString();
        return trim($fullSign);
    }
    
    public function isAdminHasRead()
    {
        if ($this->admin_has_read === 1)
            return true;
        
        return false;
    }
    
    public function setAdminHasRead($hasRead = true)
    {
        $hasRead = $hasRead ? 1 : 0;
        if ($this->admin_has_read == $hasRead)
            return true;
        
        $this->admin_has_read = $hasRead ? 1 : 0;
        return $this->save();
    }
    
    public function isMine()
    {
        if ($this->user_id !== \Auth::id())
            return false;
        
        return true;
    }
}
