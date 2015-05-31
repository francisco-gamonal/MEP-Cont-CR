<?php

namespace Mep\Components;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Collective\Html\HtmlBuilder as CollectiveHtmlBuilder;

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
        $tempData = array();
        foreach (\Auth::user()->menus as $menu) {
            if ($temp != $menu->id) {
                $temp = $menu->id;
                $Menu[$menu->route] = ['url' => $menu->url,'name' => $menu->name,'id' => $menu->id,'tasks' => $menu->tasksActive()->select('name', 'id')->get()];
            }
        }

        return $Menu;
    }
}
