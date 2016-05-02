<?php

namespace Mep\Components;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Collective\Html\HtmlBuilder as CollectiveHtmlBuilder;
use Mep\Entities\Menu;

/**
 * Description of MenuServiceProvider.
 *
 * @author Anwar Sarmiento
 */
class HtmlBuilder extends CollectiveHtmlBuilder
{
    //put your code here

    public function menu()
    {

        $temp = null;
        $Menu = array();

        foreach (\Auth::user()->menus as $menu) {
            if ($temp != $menu->id) {
                $temp = $menu->id;
                if(count($menu->tasksActive($menu->pivot->user_id)->select('name', 'id')->get()) > 0){
                    $Menu[] = [ 'id' => $menu->id,
                        'url' => $menu->url,
                        'name' => $menu->name,
                        'icon_font' => $menu->icon_font,
                        'tasks' => $menu->tasksActive($menu->pivot->user_id)->select('name', 'id')->get(),
                        'currentRoute' => $this->currentRoute()
                    ];
                }
            }
        }
        return $Menu;
    }

    private function currentRoute(){
        $currentRouteName = explode("-", \Route::currentRouteName());
        if( count($currentRouteName) > 1){
            $route = $currentRouteName[1];
            if( count($currentRouteName) > 2){
                $route = null;
                foreach ($currentRouteName as $key => $value) {
                    if($key != 0){
                        $route .= $value.'-';
                    }
                }
                $route = substr($route, 0, -1);
            }
            return $route;
        }
        return 'inicio';
    }
}
