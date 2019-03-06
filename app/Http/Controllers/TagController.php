<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class TagController extends Controller
{

	private $prefix = 'tags.'; // Para Rutas
	private $viewPrefix = 'backend.tags.'; // Para Vistas

	public function __construct(){
		$this->middleware('auth');
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(){
		return view($this->viewPrefix.'index', ['tags' => Tag::all()]);
	}

	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create(){
		return view($this->viewPrefix.'create');
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(Request $request){

		// dd($request->all());
		$input = $request->all();

		$rules = [
			// 'name' => 'unique:tags|required|max:200',
			'display_name' => 'required|max:200',
			//'image_path' => 'max:800'
		];
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return redirect()->back()
			->withErrors($validator)
			->withInput();
		} else {
			$m = new Tag;
			$m->fill($request->all());
			$m->name = str_slug($request->input('display_name'));
			$m->save();
			return redirect()->route($this->prefix.'index');
		}
	}

	/**
	* Display the specified resource.
	*
	* @param  \App\Tag  $tags
	* @return \Illuminate\Http\Response
	*/
	public function show($id){
		return view($this->viewPrefix.'show', ['t' => Tag::find($id)]);
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\Tag  $tags
	* @return \Illuminate\Http\Response
	*/
	public function edit($id){
		return view($this->viewPrefix.'edit', ['t' => Tag::find($id)]);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\Tag  $tags
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id){

		// dd($request->all());
		$input = $request->all();

		$rules = [
			// 'name' => 'unique:tags|required|max:200',
			'display_name' => 'required|max:200',
			//'image_path' => 'max:800'
		];
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return redirect()->back()
			->withErrors($validator)
			->withInput();
		} else {
			$m = Tag::find($id);
			$m->update($request->all());
			$m->name = str_slug($request->input('display_name'));
			$m->save();
			return redirect()->route($this->prefix.'index');
		}
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Tag  $tags
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id){
		$m = Tag::find($id);
		$m->delete();
		return redirect()->route($this->prefix.'index');
	}
}
