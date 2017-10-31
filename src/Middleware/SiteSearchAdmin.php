<?php

namespace Larrock\ComponentSearch\Middleware;

use Cache;
use Closure;

class SiteSearchAdmin
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
        //Cache::flush();
        $data = Cache::remember('siteSearchAdmin', 1440, function(){
            $data = [];
            /*foreach (LarrockCatalog::getModel()->whereActive(1)->with(['get_category'])->get(['id', 'title']) as $item){
                $data[$item->id]['id'] = $item->id;
                $data[$item->id]['title'] = $item->title;
                $data[$item->id]['category'] = $item->get_category->first()->title;
            }*/
            $config = config('larrock-admin-search.components');
            foreach ($config as $item){
                if($search_data = $item->search()){
                    $data = array_merge($data, $search_data);
                }
            }
            return $data;
        });
        \View::share('searchSiteAdmin', view('larrock::admin.search.module', ['search_data' => $data])->render());
        return $next($request);
    }
}
