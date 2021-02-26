<?php

namespace App\Http\Controllers;

use App\Models\Cars;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    
    public function getCars(Request $request) {
        $cars = Cars::all();
        return response()->json($cars);
        // return $cars;
    }

    public function storeCar(Request $request) {
        $car = new Cars();
        $car->make = $request->make;
        $car->model = $request->model;
        $car->save();

        return $car;
    }

    public  function editCar(Request $request, $id){
        $car = Cars::where('id',$id)->first();

        $car->make = $request->get('val_1');
        $car->model = $request->get('val_2');
        $car->save();

        return $car;
    }

    public function deleteCar(Request $request){
        $car = Cars::find($request->id)->delete();
    }

    public function getCarsSearch(Request $request)
    {
        $data = Cars::where('model', 'LIKE','%'.$request->keyword.'%')->get();
        return response()->json($data); 
    }

}
