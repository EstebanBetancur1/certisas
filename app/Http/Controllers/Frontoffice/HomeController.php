<?php

namespace App\Http\Controllers\Frontoffice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\Contact;
use App\Mail\ContactAdmin;

class HomeController extends Controller
{
    public function index()
    {
        return view('frontoffice.home.index');
    }

    public function contact(Request $request)
    {
        $post = $request->all();

        $validator = $this->validator($post);

        if ($validator->fails()) {
            // $validator->errors()->all();
            return response("Todos los campos del formulario son obligatorios.");
        }

        try {
            Mail::to($post["email"])->send(new Contact($post));
            Mail::to(setting('email_notification'))->send(new ContactAdmin($post));
        } catch (\Exception $e) {
            return response("Su mensaje no fue enviado, por favor intente mas tarde.");
        }

        return response("OK");
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'full_name'     => 'required|string|max:255',
            'company'       => 'required|string|max:255',
            'message'       => 'required|string|max:500',
            'email'         => 'required|email',
            'subject'       => 'required|string',
        ]);
    }
}
