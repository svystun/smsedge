<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $table = 'numbers';
    protected $fillable = ['cnt_id', 'num_number', 'num_created'];
    const CREATED_AT = 'num_created';
}
