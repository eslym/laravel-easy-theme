<?php


namespace Eslym\EasyTheme\Facades;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Facade;
use Eslym\EasyTheme\Contracts\Theme as ThemeContract;

/**
 * Class Theme
 * @package Eslym\EasyTheme\Facades
 *
 * @method static View render()
 * @method static Response response(int $status = 200, array $headers = [])
 * @method static ThemeContract view(string|string[] $view, array|Arrayable $data, array $mergeData)
 * @method static ThemeContract theme(?string $theme);
 * @method static string asset();
 * @method static string getTheme();
 */
class Theme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'theme';
    }
}