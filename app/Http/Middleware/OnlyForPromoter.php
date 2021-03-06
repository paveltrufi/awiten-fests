<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class OnlyForPromoter
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
      if(Auth::guest()){
        return redirect('/login');
      } else if(!Auth::user()->isPromoter()){
        return redirect('/noPermision');
      }
        return $next($request);
    }
}
