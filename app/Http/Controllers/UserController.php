<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
   public function index(Request $request){
    // $users = \App\Models\User::paginate(10);
    $users = DB::table('users')
    ->when($request->input('name'), function($query, $name){
        return $query->where('name', 'like', '%'.$name.'%');
    })
    ->orderBy('id', 'desc')
    ->paginate(10);
    return view('pages.users.index', compact('users'));
   }

   public function create(){
    return view('pages.users.create');
   }

   public function store(StoreUserRequest $request){
        // dd($request->all()); // for debug
        $data = $request->all();
        $data['password'] = Hash::make($request->password); //bcsqrt($request->password);
        $result = \App\Models\User::create($data);
        $toastType = $result ? 'success' : 'error';
        $descriptionMessage = self::getMessage('store', $toastType); // Fix the function call

        return redirect()->route('user.index')->with($toastType, $descriptionMessage);
   }

   public static function edit($id){
        $user = \App\Models\User::findOrFail($id);
        return view('pages.users.edit', compact('user'));
   }


   public static function update(UpdateUserRequest $request, User $user){
        $data = $request->validated();
        $result = $user->update($data);
        $toastType = $result ? 'success' : 'error';
        $descriptionMessage = self::getMessage('update', $toastType); // Fix the function call

        return redirect()->route('user.index')->with($toastType, $descriptionMessage);
   }

   public static function destroy(User $user){
        $result = $user->delete();
        $toastType = $result ? 'success' : 'error';
        $descriptionMessage = self::getMessage('destroy', $toastType);


        return redirect()->route('user.index')->with($toastType, $descriptionMessage);
   }

   public static function getMessage($type, $isSuccess)
   {
        $result = "";
        $status = ($isSuccess == 'success') ? 'Successfully' : 'Failure To';
        switch ($type) {
            case 'store':
                $result = "Data $status Created";
                break;
            case 'destroy':
                $result = "Data $status Deleted";
                break;
            case 'update':
                $result = "Data $status Updated";
                break;
            default:
                break;
        }

        self::showToast($result, $isSuccess);  // show toast
        return $result;
    }

    public static function showToast($description, $toastType){
        toast($description, $toastType);
    }
}