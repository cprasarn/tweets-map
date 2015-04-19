<?php namespace App\Http\Controllers;

use Cookie;
use Input;
use Response;

use Abraham\TwitterOAuth\TwitterOAuth;

use App\History;
use App\HistoryCache;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TwitterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$city = Input::get('city');
		$lat = Input::get('lat');
		$lng = Input::get('lng');
		$radius = '50km';

		$cookie = Cookie::get('laravel_session');
		$history = History::whereRaw("cookie = ? AND city = ? AND timediff(created_at, now()) > ? ", 
			array($cookie, $city, '-01:00:00'))->get();
		if (0 < $history->count()) {
			$cache = true;
			$history_id = $history->first()->id;
			$history_caches = HistoryCache::where('history_id', '=', $history_id)->get();
			$tweets = unserialize($history_caches->first()->cache);
		}
		else {
			$cache = false;
			$connection = new TwitterOAuth(env('CONSUMER_KEY'), env('CONSUMER_SECRET'), env('ACCESS_TOKEN'), env('ACCESS_TOKEN_SECRET'));
			$connection->setTimeouts(10, 15);

			$tweets = $connection->get("search/tweets", array("q" => "geocode:{$lat},{$lng},{$radius}", "f" => "realtime", "src" => "typd"));
			// Add to Histories
			$history = new History();
			$history->city = $city;
			$history->cookie = $cookie;
			$history->save();

			$history_cache = new HistoryCache();
			$history_cache->history_id = $history->id;
			$history_cache->cache = serialize($tweets);
			$history_cache->save();
		}

		$response = array(
			'status' => 'success',
			'msg' => $cache ? 'cache' : 'realtime',
			'data' => $tweets
		);

		return Response::json( $response );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
