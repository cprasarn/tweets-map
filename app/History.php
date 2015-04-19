<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model {

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'histories';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = ['cookie', 'city', 'cache'];
}
