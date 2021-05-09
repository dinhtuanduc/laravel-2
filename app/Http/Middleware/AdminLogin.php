<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class AdminLogin
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
        $admin_login_remember = $request -> cookie('admin_login_remember');
        if($admin_login_remember)
        {
            $adminCookie = DB::table('admin')->where('remember_token','=',$admin_login_remember)->first();
            if (isset($adminCookie->id) && ($adminCookie->id >0) )
            {
                return $next($request);
            }
        }
        $admin_login_remember = session('admin_login',false);
        if (!$admin_login_remember)
        {
            return redirect('backend/admin-login');
        }
        return $next($request);
    }
}
