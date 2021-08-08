<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Contact;

class Contacts extends Controller
{
  // fetch contacts
  public function index() {
    return response()->json(Contact::latest()->orderBy('created_at', 'desc')->get());
  }

  // fetch single Contact
  public function show($id) {
    return response()->json(Contact::findOrFail($id));
  }

  // add contact
  public function store(Request $request) {
    $data = json_decode($request->getContent(), true);
    $data = filter_var_array($data, FILTER_SANITIZE_STRING);
    $validator = Validator::make($data, [
      'name'  => 'required',
      'email' => 'required|email',
      'phone' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json(["success" => false, "errors" => $validator->errors()]);
    }

    Contact::create([
      'name'  => $data['name'], 
      'email' => $data['email'], 
      'phone' => $data['phone']
    ]);

    return response()->json(["success" => true]);
  }

  // update contact
  public function update(Request $request, $id) {
    $data = json_decode($request->getContent(), true);
    $data = filter_var_array($data, FILTER_SANITIZE_STRING);
    $validator = Validator::make($data, [
      'name'  => 'required',
      'email' => 'required|email',
      'phone' => 'required'
    ]);

    if ($validator->fails()) {
      return response()->json(["success" => false, "errors" => $validator->errors()]);
    }

    Contact::findorFail($id)->update([
      'name'  => $request->input(['name']), 
      'email' => $request->input(['email']), 
      'phone' => $request->input(['phone'])
    ]);

    return response()->json(["success" => true]);
  }

  // delete contact
  public function delete($id) {
    return response()->json(Contact::destroy($id));
  }
}
