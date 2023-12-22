<?php

namespace App\Http\Middleware;

use App\Http\Controllers\VisitorInformationController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isFalse;

class VisitorInformationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    final public function handle(Request $request, Closure $next): Response
    {
        if(env('VISITOR_INFO_SAVE')){
            (new VisitorInformationController())->store($request);
        }
        return $next($request);
    }
}
