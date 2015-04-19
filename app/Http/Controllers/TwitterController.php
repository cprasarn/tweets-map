<?php namespace App\Http\Controllers;

// require "vendor/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Input;
use Response;

class TwitterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
		$lat = Input::get('lat');
		$lng = Input::get('lng');
		$radius = '50km';

		$connection = new TwitterOAuth(env('CONSUMER_KEY'), env('CONSUMER_SECRET'), env('ACCESS_TOKEN'), env('ACCESS_TOKEN_SECRET'));
		$connection->setTimeouts(10, 15);

		$tweets = $connection->get("search/tweets", array("q" => "geocode:{$lat},{$lng},{$radius}", "f" => "realtime", "src" => "typd"));

		$response = array(
			'status' => 'success',
			'msg' => 'test',
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
