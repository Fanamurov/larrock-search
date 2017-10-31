<?php

namespace Larrock\ComponentSearch\Middleware;

use Cache;
use Closure;

class SiteSearch
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
        $data = Cache::remember('siteSearch', 1440, function(){
            $data = [];
            /*foreach (LarrockCatalog::getModel()->whereActive(1)->with(['get_category'])->get(['id', 'title']) as $item){
                $data[$item->id]['id'] = $item->id;
                $data[$item->id]['title'] = $item->title;
                $data[$item->id]['category'] = $item->get_category->first()->title;
            }*/
            $config = config('larrock-search.components');
            foreach ($config as $item){
                if($search_data = $item->search()){
                    $data = array_merge($data, $search_data);
                }
            }
            return $data;
        });
        \View::share('searchSite', view('larrock::front.modules.search.site-autocomplite', ['search_data' => $data])->render());
        return $next($request);
    }
}
