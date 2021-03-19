<?php
use Illuminate\Support\Facades\Route;

if(!function_exists('custom_paginator')){
    
    /* Custom pagination System Based on Lampager package
    * @param  Query     $query
    * @param  Array     $cursor
    * @param  Char      $sort 
    * @param  Integer   $sort
    * @param  Boolean   $seekable
    * @return Array     $result
    */
    function custom_paginator($query, $cursor = null, $cache = null, $sort = '>', $perPage = 10, $seekable = true)
    {
        $state_array = null;
        if(request('state')){
            $state_base64 = request('state');
            $state_decoded = base64_decode($state_base64);
            $state_array = json_decode($state_decoded,true);
        }
        //dd($state_array);
        // Cursor is used to navigate to the next or previous 'pages'
        $newCursor = null;
        // Get cursor parameters from HTTP Request
        foreach($cursor as $parameter){
            //dd($parameter);
            if($state_array['cursor'][$parameter]){
                //Add parameter to the cursor array
                $newCursor[$parameter] = $state_array['cursor'][$parameter];
            }
        }
        
        //dd($newCursor);
        
        // Create a new pagination
        $paginator = $query->lampager()
                    ->limit($perPage); // Set Number of elements Per Page (default=10)
        
        // ...
        foreach($cursor as $parameter){
            if($sort == '>')
                $paginator = $paginator->orderBy($parameter);
            else
                $paginator = $paginator->orderByDesc($parameter);
        }

        if($seekable)
            $paginator = $paginator->seekable(); // Get 'Previous Cursor' to be able to navigate backwards

        // Handle 'Next' Button Click
        if(request()->direction == "next" || request()->direction == null){
            $paginator = $paginator->forward(); // Use forward method to change the direction of the navigation
        } 
        // Handle 'Previous' Button Click
        else{
            $paginator = $paginator->backward(); // Use backward method to change the direction of the navigation
        }
        if($newCursor != null){
            $paginator = $paginator
                ->paginate($newCursor);
        }
        else{
            $paginator = $paginator
                ->paginate();
        }
        
        // Extract cursors from paginator
        $cursors = (array)$paginator;
        unset($cursors['records']);
        //dd($cursors);
        $resCursor = null;

        if(request()->direction == "next" || request()->direction == null)
            $resCursor = $cursors['nextCursor'];
        else
            $resCursor = $cursors['previousCursor'];

        // Get current route name...
        $route = Route::currentRouteName();

        $state = [
            'cursor' => $resCursor,
            'cache' => $cache
        ];
        //dd($state);
        $base64_state = base64_encode(json_encode($state));
        
        /*
        ** Router options 
        ** ['prev', $state]
        ** ['next', $state]
        */
        $prev_btn_router_options = ['prev', $base64_state];
        $next_btn_router_options = ['next', $base64_state];

        $result = [
            'items' => $paginator,
            'route' => $route,
            'prev_btn_router_options' => $prev_btn_router_options,
            'next_btn_router_options' => $next_btn_router_options
        ];
        //dd($result);
        return $result;
    }
}