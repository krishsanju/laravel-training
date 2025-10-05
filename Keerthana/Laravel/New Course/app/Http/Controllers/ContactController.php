<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    function index(){
        return view('contact');
    }

// //USING HTTP REQUEST
//     function contactsubmit(Request $request){
//         // echo $request->name;

//         $request->validate([
//             'name' => 'required|max:10',
//             'email'=> 'required|email',
//         ],
//         [
//             'name'=> 'Name proper gaa fill chai',
//             'email.required'=> 'submit chesa mundhu edho oka email evu',
//             'email.email' => 'email echavu okay but, correct ga evali kadha'
//         ]
//         ) ;

//         dd($request->all());
//     }

// USING COSTUM REQUEST
    function contactsubmit(ContactStoreRequest $request){
        // dd($request->all());
        $contact = Contact::create($request->all());
    }
}
