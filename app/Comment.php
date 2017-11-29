<?php

namespace Slisten;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const TYPE_DEFAULT = 10;
    
    protected $attributes = [
        'type' => self::TYPE_DEFAULT,
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
}
