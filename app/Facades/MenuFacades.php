<?php

namespace Mep\Facades;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Support\Facades\Facade;

/**
 * Description of MenuServiceProvider
 *
 * @author Anwar Sarmiento
 */
class MenuFacades extends Facade {

    //put your code here

    public static function Menu() {
        $temp = null;
        $Menu = array();
        $tempData = array();
        foreach (\Auth::user()->menus as $menu) {

            if ($temp != $menu->id) {
                $temp = $menu->id;
                $Menu[$menu->name] = ['url'=>$menu->url,'id'=>$menu->id,'task'=>$menu->tasksActive()->select('name','id')->get()];
            }
        }
        return $Menu;
    }

}
