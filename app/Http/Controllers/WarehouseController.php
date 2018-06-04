<?php

namespace App\Http\Controllers;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\DB;


  //Take the control of the Warehouse
class WarehouseController extends Controller
{

  public function index(){

      return view('index');
  }
  public function addItem(){

      return view('Items/addItem');
  }

    public function store(){
      $data = Request()->validate([
        'itemName' => ['required' , 'unique:items,itemName'],
        'quantity' => 'required',
        'unity' => 'required',
        'price' => 'required'
      ]);

      Item::create([
        'id' => null,
        'itemName' => $data['itemName'],
        'quantity' => $data['quantity'],
        'unity' => $data['unity'],
        'price' => $data['price'],
      ]);
      $success="Artículo agregado correctamente";
      return view('Items/addItem', compact('success'));

    }

    public function updateItem(){


      if (strlen($_REQUEST['itemName'])!=0 && strlen($_REQUEST['quantity'])!=0 && strlen($_REQUEST['unity'])!=0 && strlen($_REQUEST['price'])!=0) {

        $id=$_REQUEST['id'];
        $item = Item::find($id);
        $item->itemName = $_REQUEST['itemName'];
        $item->quantity = $_REQUEST['quantity'];
        $item->unity = $_REQUEST['unity'];
        $item->price = $_REQUEST['price'];
        $item->save();

        $items = Item::all();
        $updateSuccess="Producto actualizado correctamente";
        return view('Items/showItems', compact('items','updateSuccess'));

      }else {
        $id = $_REQUEST['id'];
        $item= Item::find($id);

        $error="Debe llenar todos los campos";
        return view('Items/editItem', compact('item','error'));
      }





    }

    public function showItems(){

      $items = Item::all();
      return view('Items/showItems', compact('items'));
    }

    public function editItem(){
      $id = $_REQUEST['id'];
      $item= Item::find($id);

      return view('Items/editItem', compact('item'));
    }

    public function deleteItem(){
      $id = $_REQUEST['id'];

      Item::find($id)->delete();




      $items = Item::all();
      return view('Items/showItems', compact('items'));

    }


    public function addCategory(){


      return view('Catalogue/addCategory');
    }

    public function storeCategory(){


      $data = Request()->validate([
        'categoryName' => ['required' , 'unique:categories,categoryName'],
        'numberCat' => ['required' , 'unique:categories,numberCat']

      ]);

      DB::table('categories')->insert([
        'id' => null,
        'categoryName' => $data['categoryName'],
        'numberCat' => $data['numberCat'],
        ]);



      $success="Categoria agregada correctamente";
      return view('Catalogue/addCategory', compact('success'));
    }

    public function showCategories(){

      $categories = DB::table('categories')->select('id','categoryName', 'numberCat')->get();
      return view('Catalogue/showCategories', compact('categories'));
    }

    public function editCategory(){
        $id = $_REQUEST['id'];
        $Category = DB::table('categories')
        ->select('id','categoryName', 'numberCat')
        ->where('id', $id)
        ->get();
        return view('Catalogue/editCategory', compact('Category'));
    }

}
