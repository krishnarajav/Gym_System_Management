<?php

namespace App\Models;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $table = 'Admin'; 
    protected $fillable = ['id', 'password', 'name'];

    /**
     * Validate a user against the given credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(array $credentials)
    {
        $plain = $credentials['password'];

        return app('hash')->check($plain, $this->getAuthPassword());
    }
}