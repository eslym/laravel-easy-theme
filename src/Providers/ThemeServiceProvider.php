<?php


namespace Eslym\EasyTheme\Providers;


use Eslym\EasyTheme\Contracts\Theme as ThemeContract;
use Eslym\EasyTheme\ThemeViewFinder;
use Illuminate\Support\ServiceProvider;
use Eslym\EasyTheme\Theme;
use Illuminate\View\Factory;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(){
        $this->app->bind('view.finder', function ($app) {
            return new ThemeViewFinder($app['files'], config('theme.path'));
        });
        $this->app->singleton('theme.view', function ($app){
            $resolver = $app['view.engine.resolver'];
            $finder = $app['theme.finder'];
            $factory = new Factory($resolver, $finder, $app['events']);
            $factory->setContainer($app);
            $factory->share('app', $app);
            return $factory;
        });
        $this->app->bind(ThemeContract::class, function(){
            return new Theme();
        });
        $this->app->alias(ThemeContract::class, 'theme');
    }

    public function register()
    {
        $this->publishes([
            __DIR__.'/../../config/theme.php' => config_path('theme.php')
        ], 'config');
    }
}