<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $fillable = ['cnt_code', 'cnt_title', 'cnt_created'];
    const CREATED_AT = 'cnt_created';
}
