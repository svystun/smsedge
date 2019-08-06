<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class LogGlobal extends Model
{
    protected $table = 'send_log';
    protected $fillable = ['usr_id', 'num_id', 'log_message', 'log_success', 'log_created'];
    const CREATED_AT = 'log_created';
}
