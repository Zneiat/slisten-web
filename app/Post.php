<?php

namespace Slisten;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const STATUS_DEFAULT = 10;
    const TYPE_DEFAULT = 10;
    
    protected $attributes = [
        'sign'   => '',
        'status' => self::STATUS_DEFAULT,
        'type'   => self::TYPE_DEFAULT,
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
}
