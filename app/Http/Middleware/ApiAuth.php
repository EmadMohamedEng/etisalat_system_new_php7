<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use App\User;
use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $mobileToken = $request->input('mobile_token');	
		//check if toekn sent
		if(!$mobileToken)
		{return response()->json(['error' => 'Access Denied1']);}
		// check if user exist
		$userData = User::where('mobile_token','=',$mobileToken);
		if ($userData->count() < 1)
		{return response()->json(['error' => 'Access Denied2']);}
		//check if user login
		$userData = $userData->get();
		if ($userData[0]->is_login != 1)
		{return response()->json(['error' => 'Access Denied3']);}
		//forward
		return $next($request);
		
		
    }
}
