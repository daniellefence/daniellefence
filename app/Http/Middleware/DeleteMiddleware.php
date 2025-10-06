<?php

namespace App\Http\Middleware;

use App\Models\Photo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DeleteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request):Response $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $type = $request->input('type');
        if ($type == 'photo') {
            $photo = Photo::findOrFail($request->input('guid'));
            $ids = [
                'product_category_id',
                'product_subcategory_id',
                'product_id',
                'blog_id',
                'review_id',
                'carousel_id',
                'special_id',
            ];
            foreach ($ids as $id) {
                if (isset($photo->id)) {
                    switch ($id) {
                        case 'product_category_id':
                            if (permission()->check('CategoryDelete')) {
                                return $next($request);
                            }
                            break;
                        case 'product_subcategory_id':
                            if (permission()->check('productSubcategoryDelete')) {
                                return $next($request);
                            }
                            break;
                        case 'product_id':
                            if (permission()->check('productDelete')) {
                                return $next($request);
                            }
                            break;
                        case 'blog_id':
                            if (permission()->check('blogDelete')) {
                                return $next($request);
                            }
                            break;
                        case 'review_id':
                            if (permission()->check('reviewDelete')) {
                                return $next($request);
                            }
                            break;
                        case 'carousel_id':
                            if (permission()->check('carouselDelete')) {
                                return $next($request);
                            }
                            break;
                        case 'special_id':
                            if (permission()->check('specialDelete')) {
                                return $next($request);
                            }
                            break;
                    }
                }
            }
        }
        if ($type == 'pip') {
            $permission = 'productDelete';
        } else {
            $permission = $type.'Delete';
        }

        if (Auth::check() && auth()->user()->hasPermission($permission)) {
            return $next($request);
        }
        abort(401);
    }
}
