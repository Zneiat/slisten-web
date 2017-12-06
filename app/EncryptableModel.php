<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class EncryptableModel extends Model
{
    protected $encryptable = [];
    
    public function getAttribute($key)
    {
        $value = parent::getAttribute($key);
        
        if (in_array($key, $this->encryptable)) {
            try {
                $value = decrypt($value);
            } catch (\Exception $e) {}
        }
        
        return $value;
    }
    
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = encrypt($value);
        }
        
        return parent::setAttribute($key, $value);
    }
    
    public function attributesToArray()
    {
        $attributes = parent::attributesToArray(); // call the parent method
        
        foreach ($this->encryptable as $key) {
            if (isset($attributes[$key])){
                try {
                    $attributes[$key] = decrypt($attributes[$key]);
                } catch (\Exception $e) {}
            }
        }
        return $attributes;
    }
}