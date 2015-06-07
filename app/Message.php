<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['message'];

    /**
     * Return the user record of the person who created the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function user()
    {
        return $this->belongsTo('App\User');
    }

}
