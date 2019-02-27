<?php

namespace App\Http\Middleware;

use Closure;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param array $permissionRole
     * @return mixed
     */
    public function handle($request, Closure $next, ...$permissionRole)
    {
        // Check if not input permission Role, set to guest automatic
        if (count($permissionRole) == 0) array_push($permissionRole, 'guest');

        // Redirect to homepage
        if (in_array('REDIRECT_HOME_PAGE', $permissionRole)) return $this->redirectUserToHomePage();

        // Correcting PermissionRole
        $permissionRole = $this->correctingRole($permissionRole);
        
        // Get Role Visitor / User
        $userRole = $this->getUserRole();

        // Check User Role in PermissionRole
        $userAccept = in_array($userRole, $permissionRole);

        ## If User Not Permitted
        if (!$userAccept) return abort(401);

        return $next($request);
    }

    /**
     * Get Current User Role
     * 
     * @return array
     */
    public function getUserRole()
    {
        if (!Auth()->check())
        {
            return "guest";
        } else {
            return strtolower(str_replace('App\\Models\\', '', Auth()->user()->role_type));
        }
    }


    /**
     * For Correcting a input Permission Role
     * 
     * @param   array $permissionRole
     * @return  array
     */
    public function correctingRole($permissionRole){
        $tmp_permissionRole = [];
        for ($i=0;$i < count($permissionRole);$i++) {
            array_push($tmp_permissionRole, strtolower($permissionRole[$i]));
        }
        return $tmp_permissionRole;
    }


    /**
     * Redirect User To Homapage Role
     * 
     * @return  closure
     */
    public function redirectUserToHomePage()
    {
        if (!Auth()->check())
        {
            return redirect()->route('login');
        } else {
            $userRole = $this->getUserRole();
            return redirect()->route($userRole.'.home');
        }
    }
}
