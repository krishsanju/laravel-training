<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class FavouriteConversion extends Model
{
    protected $table = 'favourite_conversions';

    protected $fillable = [
        'user_id',
        'from_currency',
        'to_currency',
        'amount',
        'converted_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function saveConvertion($user, $request)
    {
        return self::create([
            'user_id'       => $user->id,
            'from_currency' => strtoupper($request['query']['from']),
            'to_currency'   => strtoupper($request['query']['to']),
            'amount'           => $request['query']['amount'],
            'converted_amount' => $request['result'],
        ]);
    }
}
