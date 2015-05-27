<?php namespace Mep\Providers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Collective\Html\HtmlServiceProvider as colletiveServiceProvider;
use Mep\Components\HtmlBuilder;
/**
 * Description of HtmlServiceProvider
 *
 * @author Anwar Sarmiento
 */
class HtmlServiceProvider extends colletiveServiceProvider {
    //put your code here
    
    /**
	 * Register the HTML builder instance.
	 *
	 * @return void
	 */
	protected function registerHtmlBuilder()
	{
		$this->app->bindShared('html', function($app)
		{
			return new HtmlBuilder($app['url']);
		});
	}
}
