<?php

namespace Larrock\ComponentSearch;

use Cache;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Larrock\Core\Traits\ShareMethods;

class AdminSearchController extends Controller
{
    use ShareMethods;

    public function __construct()
    {
        $this->shareMethods();
        $this->middleware(\LarrockPages::combineAdminMiddlewares());
    }

    public function index(Request $request)
    {
        $result = [];
        $text = $request->get('text');
        $components = \Config::get('larrock-admin-search.components');

        foreach ($components as $item){
            if($item->searchable){
                $item->search = $item->model::search($text)->get();
                $result[$item->name] = $item;
            }
        }

        return view('larrock::admin.search.result', ['data' => $result]);
    }

    /**
     * @return string
     * @throws \Throwable
     */
    public function initSearchModule()
    {
        $data = Cache::rememberForever('siteSearchAdmin', function(){
            $data = [];
            $config = config('larrock-admin-search.components');
            foreach ($config as $item){
                if($search_data = $item->search(TRUE)){
                    $data = array_merge($data, $search_data);
                }
            }
            return $data;
        });
        return response()->json($data);
    }
}