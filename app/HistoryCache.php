<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryCache extends Model {
	/**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'history_caches';

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = ['history_id', 'cache'];
}
