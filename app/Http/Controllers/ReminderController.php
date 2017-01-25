<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquent\UserRepository;
use App\Events\ReminderEvent;
use Illuminate\Http\Request;
use Mail;
use View;
use Input;
use Reminder;
use Event;
use Redirect;
use Session;

class ReminderController extends Controller
{
    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    public function create()
    {
        return view('reminders.create');
    }

    public function store()
    {
        try {
            $login = Input::get('login');
            $user = $this->users->findByLogin($login);
            //dd($user);

            if ($user) {
                ($reminder = Reminder::exists($user)) || ($reminder = Reminder::create($user));
                Event::fire(new ReminderEvent($user, $reminder));
            }

            // mail send (insanely)
            $this->sendEmail($user, $reminder);

            return View::make('reminders.store');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors("Username or e-mail address not found");
        }
    }

    public function edit($id, $code)
    {
        $user = $this->users->findById($id);

        if (Reminder::exists($user, $code)) {
            return View::make('reminders.edit', ['id' => $id, 'code' => $code]);
        } else {
            //incorrect info was passed
            return Redirect::to('/');
        }
    }

    public function update(Request $request,$id, $code)
    {
        $this->validate($request, [
            'password' => 'required|min:5|confirmed',
            'password_confirmation' => 'required|min:5',
        ]);

        $password = Input::get('password');
        $passwordConf = Input::get('password_confirmation');

        $user = $this->users->findById($id);
        $reminder = Reminder::exists($user, $code);

        //incorrect info was passed.
        if ($reminder == false) {
            return Redirect::to('/');
        }

        if ($password != $passwordConf) {
            Session::flash('error', 'Passwords must match.');
            return View::make('reminders.edit', ['id' => $id, 'code' => $code]);
        }

        Reminder::complete($user, $code, $password);

        return Redirect::to('/');
    }

    public function sendEmail($user, $reminder)
    {
        $data = [
            'email' => $user->email,
            'name' => $user->full_name,
            'subject' => 'Reset Your Password',
            'code' => $reminder->code,
            'id' => $user->id
        ];

//        dump($data);

        Mail::send('emails.reminder', $data, function ($m) use ($user) {
            $m->from('dgda@technovista.com.bd', 'DGDA');
            $m->to($user->official_email, $user->full_name)->subject('Your Forgot Password Reminder!');
        });
    }
}