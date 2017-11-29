<?php

namespace Slisten\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Slisten\Models\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $role
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Slisten\Models\User whereRole($value)
 */
class User extends Authenticatable
{
    use Notifiable;
    
    const ROLE_USER = 10;
    const ROLE_ADMIN = 20;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @link http://d.laravel-china.org/docs/5.4/eloquent-serialization#隐藏来自-JSON-的属性
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    /**
     * 用户页面权限处理
     *
     * @param $role string|array 角色名
     */
    public function checkRole($role)
    {
        if ($this->matchRole($role)) {
            return;
        }
        
        abort(403, '你无权访问该页面');
    }
    
    /**
     * 该用户是否有指定角色名
     *
     * @param $roles string|array
     * @return bool
     */
    public function matchRole($roles)
    {
        if (count($roles) === 0) {
            return true;
        }
        
        foreach ($roles as $role) {
            if ($role === '?') {
                return true;
            }
            else if ($role === self::ROLE_USER) {
                return true;
            }
            else if ($role === $this->role) {
                return true;
            }
        }
        
        return false;
    }
}