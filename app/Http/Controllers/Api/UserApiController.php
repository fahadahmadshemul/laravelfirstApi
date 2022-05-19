<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserApiController extends Controller
{
    //showUser
    public function showUser($id = null){
        if($id){
            $users = User::find($id);
            return response()->json(['users'=>$users], 200);
        }else{
            $users = User::get();
            return response()->json(['users'=>$users], 200);
        }
    }
    //addUser
    public function addUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            
            $rules = [
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required'
            ];
            $customMessage = [
                'name.required'=>'Name is Required',
                'email.required'=>'Email is Required',
                'email.email'=>'Email Must be a valid Email',
                'password.required'=>'Password is Required',
            ];
            
            $validator = Validator::make($data, $rules, $customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();
            $message = "User Added Successfully...!";
            return response()->json(['message'=>$message], 201);
        }
    }

    public function addMultipleUser(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'users.*.name'=>'required',
                'users.*.email'=>'required|email|unique:users',
                'users.*.password'=>'required',
            ];
            $customMessage = [
                'users.*.name.required'=>'Name is Required',
                'users.*.name.required'=>'Email is Required',
                'users.*.name.email'=>'Email must be a valid Email Address',
                'users.*.password.required'=>'Password is Required',
            ];
            $validator = Validator::make($data, $rules, $customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }
            foreach($data['users'] as $user){
                $save = new User;
                $save->name = $user['name'];
                $save->email = $user['email'];
                $save->password = Hash::make($user['password']);
                $save->save();
                
            }
            $message = "User Added Successfully...!";
            return response()->json(['message'=>$message], 201);
        }
    }
    //update_user
    public function update_user(Request $request, $id){
        if($request->isMethod('put')){
            $data = $request->all();

            $rules = [
                'name'=>'required',
                'password'=>'required',
            ];
            $customMessage = [
                'name.required'=>'Name is Required',
                'password.required'=>'Password is Required',
            ];
            $validator = Validator::make($data, $rules, $customMessage);
            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }
            $update = User::findOrFail($id);
            $update->name = $data['name'];
            $update->password = Hash::make($data['password']);
            $update->save();
            $message = "Update User Successfully...!";
            return response()->json(["message"=>$message], 202);
        }
    }
    //single_column_update
    public function single_column_update(Request $request, $id){
        if($request->isMethod('patch')){
            $data = $request->all();

            $rules = [
                'password'=>'required'
            ];
            $customMessage = [
                'password'=>'Password is Required'
            ];

            $validator = Validator::make($data, $rules, $customMessage);

            $update = User::findOrFail($id);
            $update->password = Hash::make($data['password']);
            $update->save();
            $message = 'Update Password Successfully...!';
            return response()->json(['message'=>$message], 202);
        }
    }
    //delete_singleUser
    public function delete_singleUser($id = null){
        $delete = User::findOrFail($id)->delete();
        $message = "Delete Single User Successfully..!";
        return response()->json(['message'=>$message], 200);
    }
    //deleteByJson
    public function deleteByJson(Request $request){
        if($request->isMethod('delete')){
            $data = $request->all();

            $deleteby_id = User::where('email', $data['email'])->delete();

            $message = "Delete User Successfully..!";
            return response()->json(['message'=>$message], 200);
        }
    }
    //multipleDeleteParam
    public function multipleDeleteParam($ids){
        $ids = explode(',', $ids);
        $delete = User::whereIn('id', $ids)->delete();
        $message = "Delete Multiple User Successfully...!";
        return response()->json(['message'=>$message], 200);
    }
    //multipleDeleteJson
    public function multipleDeleteJson(Request $request){
        if($request->isMethod('delete')){
            $data = $request->all();
            $delete = User::whereIn('id', $data['ids'])->delete();
            $message = "Delete Multiple User Successfully..!";
            return response()->json(['message'=>$message], 200);
        }
    }
}
