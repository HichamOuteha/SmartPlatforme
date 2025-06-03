<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()) {
            return redirect('login');
        }

        $userRole = $request->user()->role;
        
        if ($userRole !== $role) {
            Log::warning('Unauthorized access attempt', [
                'user_id' => $request->user()->id,
                'user_role' => $userRole,
                'required_role' => $role
            ]);
            
            return redirect()
                ->back()
                ->with('error', 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
        }

        return $next($request);
    }
} 
?>