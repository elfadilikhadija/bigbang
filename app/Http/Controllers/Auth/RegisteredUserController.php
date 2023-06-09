<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bacc;
use App\Models\Master;
use App\Models\License;
use App\Models\Phd;
use App\Models\Phdproject;
use App\Models\Proffeseur;
use App\Models\Proffessionnel;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;





class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

     protected $redirectTo = '/';

    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */




    public function store(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'UserName' => 'required|string|max:255',
        //     'PhoneNumber' => 'required|string|max:12',
        //     'SocietName' => 'required|string|max:255',
        //     'reserech_id' => 'required|integer|max:255',
        //     'email' => 'required|string|email|max:255|unique:'.User::class,
        //     'password' => ['required', Rules\Password::defaults()],
        // ]);

        $user = User::create([
            'UserName' => $request->UserName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'PhoneNumber'=>$request->number,
        ]);

          if ($request->category==="bac+2") {
            $user->baccs =  Bacc::create([
                'UnivercityName' => $request->university,
                'EtablisementName' => $request->etablessement,
                'Filere'=>$request->filere,
                'reserech_id'=>  $user->id,
            ]);
          }elseif ($request->category==="License") {
            $user->licenses =  License::create([
                'UnivercityName' => $request->university,
                'EtablisementName' => $request->etablessement,
                'Filere'=>$request->filere,
                'reserech_id'=>  $user->id,
            ]);
          }
          elseif ($request->category==="master") {
            $user->masters =  Master::create([
                'UnivercityName' => $request->university,
                'EtablisementName' => $request->etablessement,
                'Filere'=>$request->filere,
                'reserech_id'=>  $user->id,
            ]);
          }
          elseif ($request->category==="phd") {
            $user->phds =  Phd::create([
                'UnivercityName' => $request->university,
                'EtablisementName' => $request->etablessement,
                'Filere'=>$request->filere,
                'reserech_id'=>  $user->id,
            ]);
          }
          elseif ($request->category==="phd_project") {
            $user->phdprojects =  Phdproject::create([
                'UnivercityName' => $request->university,
                'EtablisementName' => $request->etablessement,
                'Filere'=>$request->filere,
                'reserech_id'=>  $user->id,
            ]);
          }
          elseif ($request->category==="proffeseur") {
            $user->proffeseurs =  Proffeseur::create([
                'UnivercityName' => $request->university,
                'EtablisementName' => $request->etablessement,
                'Filere'=>$request->filere,
                'reserech_id'=>  $user->id,
            ]);
          }
          elseif ($request->category==="proffessionnel") {

            $user->proffissionnels =  Proffessionnel::create([
                'SocietName' => $request->SocietName,
                'reserech_id'=>  $user->id,
            ]);
          }


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);


        // return Inertia::render('Comps/Home');
    }
}
