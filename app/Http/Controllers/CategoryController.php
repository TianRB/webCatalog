<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoryController extends Controller
{

	private $prefix = 'category.'; // Para Rutas
	private $viewPrefix = 'backend.category.'; // Para Vistas

	public function __construct(){
		$this->middleware('auth');
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index(){
		return view($this->viewPrefix.'index', ['category' => Category::all()]);
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
			// 'name' => 'unique:category|required|max:200',
			'display_name' => 'required|max:200',
			//'image_path' => 'max:800'
		];
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return redirect()->back()
			->withErrors($validator)
			->withInput();
		} else {
			$m = new Category;
			$m->fill($request->all());
			$m->name = str_slug($request->input('display_name'));
			$m->save();
			return redirect()->route($this->prefix.'index');
		}
	}

	/**
	* Display the specified resource.
	*
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function show($id){
		return view($this->viewPrefix.'show', ['c' => Category::find($id)]);
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function edit($id){
		return view($this->viewPrefix.'edit', ['c' => Category::find($id)]);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function update(Request $request, $id){

		// dd($request->all());
		$input = $request->all();

		$rules = [
			// 'name' => 'unique:category|required|max:200',
			'display_name' => 'required|max:200',
			//'image_path' => 'max:800'
		];
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return redirect()->back()
			->withErrors($validator)
			->withInput();
		} else {
			$m = Category::find($id);
			$m->update($request->all());
			$m->name = str_slug($request->input('display_name'));
			$m->save();
			return redirect()->route($this->prefix.'index');
		}
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param  \App\Category  $category
	* @return \Illuminate\Http\Response
	*/
	public function destroy($id){
		$m = Category::find($id);
		$m->delete();
		return redirect()->route($this->prefix.'index');
	}
}
