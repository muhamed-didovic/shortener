<?php

declare(strict_types=1);

namespace MuhamedDidovic\Shortener\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class ModifiesUrlRequestData
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
        if (! $request->has('url')) {
            return $next($request);
        }

        $validator = Validator::make($request->only('url'), [
            'url' => [
                'regex:#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i',
            ],
        ]);

        if ($validator->fails()) {
            $request->merge([
                'url' => 'http://'.$request->url,
            ]);
        }

        return $next($request);
    }
}
