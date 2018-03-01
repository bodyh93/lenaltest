<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Date extends Model
{
    public $table = 'dates';
    protected $fillable = [
        'day',
        'month',
        'year',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function getCustomDates()
    {
        $userId = Auth::user()->id;
        if ($userId === 1)
            return self::orderBy('created_at','desc')->paginate('10');
        return self::where('user_id', $userId)->orderBy('created_at','desc')->paginate('10');
    }
}
