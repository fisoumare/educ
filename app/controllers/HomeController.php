<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

    public function getIndex()
    {
        return Redirect::to('home/login');
    }

	public function getLogin()
    {
        return View::make('login');
	}

    public function postLogin()
    {
        //var_dump(Input::all());
        $val = Validator::make(
            Input::all(),
            array(
                'identifiant'=>'required',
                'mdp'=>'required_with_all:email'
            )
        );

        if($val->fails()){
            return Redirect::to('home/login')->withErrors($val)->withInput();
        }
        else
        {
            $user = User::actif()
                ->where('identifiant','=',Input::get('identifiant'))
                ->where('mdp','=',sha1(Input::get('mdp')))
                ->first();
            if(!empty($user->identifiant)){
                Session::put('user_id',$user->id);
                return Redirect::to('admin');
            }
            else{
                return Redirect::to('home/login')->withInput()->with('msg','L\'identifiant ou le mot de passe est invalide');
            }
        }
    }

    public function getLogout()
    {
        if(Session::has('user_id')){
            Session::forget('user_id');
        }

        return \Illuminate\Support\Facades\Redirect::to('home');
    }



}