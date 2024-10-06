<?php

namespace App\Http\Controllers\Auth;
 
use App\Models\User;
use Inertia\Inertia;
use App\Models\chats;
use Illuminate\Http\Request;
use App\Events\activeUserStatus;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller; 

class authController extends Controller
{

   public function dashboard(Request $request){ 
      
      $currentUserId = auth()->id(); 
      $selectedUserId = $request->chat; 
      $chats = chats::where(function ($query) use ($currentUserId, $selectedUserId) {
                $query->where('sender_id', $currentUserId)
                      ->where('reciver_id', $selectedUserId);
            })
            ->orWhere(function ($query) use ($currentUserId, $selectedUserId) {
                $query->where('sender_id', $selectedUserId)
                      ->where('reciver_id', $currentUserId);
            })
            ->orderBy('created_at', 'asc')
            ->get(); 
      $users = User::where('id','!=',Auth::user()->id)->get(); 
      broadcast(new activeUserStatus(User::find(auth()->id())));

      return Inertia::render('Auth/dashboard', [
               'contacts' => $users,
               'chats'=> $request->chat ? $chats : [],  
         ]); 
   }

   public function store(Request $request ){
      // validate  
      $filds = $request -> validate([ 
      'avatar' => ['mimes:png,jpg,jpeg','nullable'],
      'name' => ['required','max:255'],
      'email' => ['required','email','unique:users'],
      'password' => ['required','confirmed']
      ]); 
      if($request->hasFile('avatar')){ 
    
         $file = $request->file('avatar');
         $ext = $file->getClientOriginalExtension();
         $fileName = time().'.'.$ext;  
         $file->move('uploads/avatar/', $fileName);
         $filds['avatar'] = $fileName; 
      } 
      //Register
      $user = User::create($filds);  
      //Login
      Auth::login($user);

      // Redirects 
      return redirect('/');
   }

   public function login( Request $request){
      $credentials = $request->validate([
         'email' => ['required', 'email'],
         'password' => ['required'],
     ]);

     if (Auth::attempt($credentials,$request->remember)) {
         $request->session()->regenerate();  
         return redirect()->intended('/dashboard');
     }  
     return back()->withErrors([
         'email' => 'The provided credentials do not match our records.',
     ])->onlyInput('email');
   }

   public function logout(Request $request){ 

      Auth::logout();
 
      $request->session()->invalidate();
   
      $request->session()->regenerateToken();
   
      return redirect('/');
   } 
}
