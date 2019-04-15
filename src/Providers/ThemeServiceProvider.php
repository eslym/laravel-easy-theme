<?php


namespace Eslym\EasyTheme\Providers;


use Eslym\EasyTheme\Contracts\Theme as ThemeContract;
use Eslym\EasyTheme\Tools\ThemeViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Eslym\EasyTheme\Tools\Theme;
use Illuminate\Translation\Translator;
use Illuminate\View\Factory;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(){
        $theme_path = config('theme.path', 'public/themes');
        $this->app->bind('theme.finder', function ($app) use ($theme_path){
            return new ThemeViewFinder($app['files'], $theme_path, config('theme.views', 'views'));
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
        $this->app->singleton('theme.translator', function ($app) use ($theme_path) {
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];
            $trans = new Translator($loader, $locale);
            $trans->setFallback($app['config']['app.fallback_locale']);
            $lang = config('theme.lang', 'lang');
            /** @var Filesystem $files */
            $files = $app['files'];
            foreach ($files->directories($theme_path) as $theme){
                $trans->addNamespace($files->basename($theme), "$theme/$lang");
            }
            return $trans;
        });
    }

    public function register()
    {
        $this->publishes([
            __DIR__.'/../../config/theme.php' => config_path('theme.php')
        ], 'config');
    }
}