<?php namespace App\Http\Controllers;

use Cookie;
use Crypt;
use Input;
use Redirect;

use App\History;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HistoriesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// $cookie = isset($_COOKIE['laravel_session']) ? Crypt::decrypt($_COOKIE['laravel_session']) : null;
		$cookie = Cookie::get('laravel_session');
		$histories = isset($cookie) ? History::where('cookie', '=', $cookie)->get() : null;

		// return Response::json($histories);
		return view('histories.index', compact('histories'));
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
