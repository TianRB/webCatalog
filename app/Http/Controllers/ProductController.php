<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class ProductController extends Controller
{

  private $prefix = 'products.'; // Para Rutas
  private $viewPrefix = 'backend.products.'; // Para Vistas

  public function __construct(){
    $this->middleware('auth');
  }

  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(){
    return view($this->viewPrefix.'index', ['products' => Product::all()]);
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
      // 'name' => 'unique:products|required|max:200',
      'display_name' => 'required|max:200',
      //'image_path' => 'max:800'
    ];
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator)
      ->withInput();
    } else {
      $m = new Product;
      $m->fill($request->all());
      $m->name = str_slug($request->input('display_name'));
      $m->available = ($request->input('available') ? true : false);
      // img_front
      if ($request->img != null) {
        $file = Input::file('img');
        $file_name = str_random(16).'.'.$file->getClientOriginalExtension();
        $m->img = Product::$image_path.$file_name;
        $request->img->move(Product::$image_path, $file_name);
      }
      $m->save();
      if ($request->pics) {
        foreach ($request->pics as $image) {
          $file_name = str_random(16).'.'.$image->getClientOriginalExtension();
          $pic = new Pic;
          $pic->path = Product::$image_path.$file_name;
          $image->move(Product::$image_path, $file_name);
          $m->pics()->save($pic);
        }
      }
      $m->save();
      return redirect()->route($this->prefix.'index');
    }
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Product  $products
  * @return \Illuminate\Http\Response
  */
  public function show($id){
    return view($this->viewPrefix.'show', ['p' => Product::find($id)]);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Product  $products
  * @return \Illuminate\Http\Response
  */
  public function edit($id){
    return view($this->viewPrefix.'edit', ['p' => Product::find($id)]);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Product  $products
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id){

    // dd($request->all());
    $input = $request->all();

    $rules = [
      // 'name' => 'unique:products|required|max:200',
      'display_name' => 'required|max:200',
      //'image_path' => 'max:800'
    ];
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator)
      ->withInput();
    } else {
      $m = Product::find($id);
      $m->update($request->all());
      $m->name = str_slug($request->input('display_name'));
      $m->available = ($request->input('available') ? true : false);
      // img_front
      if ($request->img != null) {
        $file = Input::file('img');
        $file_name = str_random(16).'.'.$file->getClientOriginalExtension();
        $m->img = Product::$image_path.$file_name;
        $request->img->move(Product::$image_path, $file_name);
      }
      $m->save();
      return redirect()->route($this->prefix.'index');
    }
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Product  $products
  * @return \Illuminate\Http\Response
  */
  public function destroy($id){
    $m = Product::find($id);
    $m->delete();
    return redirect()->route($this->prefix.'index');
  }
}
