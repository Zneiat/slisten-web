<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Post
 *
 * @property int $id
 * @property string $content
 * @property string $sign
 * @property int $user_id
 * @property int $status
 * @property int $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read mixed $content_decrypted
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereUserId($value)
 * @mixin \Eloquent
 * @property array $users_has_read
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Post whereAdminHasRead($value)
 */
class Post extends EncryptableModel
{
    const STATUS_DEFAULT = 10;
    const TYPE_DEFAULT = 10;
    
    protected $attributes = [
        'sign'           => '',
        'users_has_read' => '[]',
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
    
    protected $casts = [
        'users_has_read' => 'json',
    ];
    
    protected $encryptable = [
        'content',
    ];
    
    protected $hidden = [
        'user'
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
    
    public function getFullSign()
    {
        $fullSign = '';
        if (!empty(trim($this->sign)))
            $fullSign .= $this->sign . ' · ';
        $fullSign .= $this->created_at->toDateString();
        return trim($fullSign);
    }
    
    public function isHasRead()
    {
        if (!\Auth::check())
            return false;
            
        if (is_array($this->users_has_read) && in_array(\Auth::id(), $this->users_has_read))
            return true;
        
        return false;
    }
    
    public function setHasRead($userId, $hasRead = true)
    {
        if (!\Auth::check())
            return false;
        
        if ($hasRead) {
            if ($this->isHasRead())
                return true;
            
            $users = $this->users_has_read;
            $users[] = $userId;
            $this->users_has_read = $users;
            
            return $this->save();
        } else {
            if (!$this->isHasRead())
                return true;
    
            $users = $this->users_has_read;
            $after = [];
            foreach ($users as $id) {
                if ($id !== $userId)
                    $after[] = $id;
            }
            $this->users_has_read = $after;
            
            return $this->save();
        }
    }
    
    public function isMine()
    {
        if ($this->user_id == \Auth::id())
            return true;
        
        return false;
    }
}
