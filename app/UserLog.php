<?php namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 * @package App
 */
class UserLog extends Model
{
    protected $table = 'users';
    protected $fillable = ['usr_name', 'usr_active', 'usr_created'];
    const CREATED_AT = 'usr_created';
}
