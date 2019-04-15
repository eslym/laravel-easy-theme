<?php


namespace Eslym\EasyTheme\Tools;

use Eslym\EasyTheme\Contracts\Theme as ThemeContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response as ResponseContract;
use Illuminate\Support\Facades\Response;

class Theme implements ThemeContract
{
    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var string
     */
    protected $view;

    /**
     * @var string
     */
    protected $theme;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $mergeData;

    public function __construct()
    {
        $this->factory = app('theme.view');
        $this->theme = config('theme.default');
    }

    /**
     * Compile and render the view.
     * @return View
     * @throws BindingResolutionException
     */
    public function render(): View
    {
        return $this->factory->make("{$this->getTheme()}:{$this->view}", $this->data, $this->mergeData);
    }

    /**
     * Return response.
     * @param int $status
     * @param array $headers
     * @return ResponseContract
     * @throws BindingResolutionException
     */
    public function response(int $status = 200, array $headers = []): ResponseContract
    {
        return Response::make($this->render(), $status, $headers);
    }

    /**
     * Set view.
     * @param string[]|string $view
     * @param array|Arrayable $data
     * @param array $mergeData
     * @return ThemeContract
     */
    public function view($view, $data = [], array $mergeData = []): ThemeContract
    {
        $parts = explode(':', $view, 2);
        if (isset($parts[1])) {
            $this->theme = $parts[0];
            $view = $parts[1];
        }
        $this->view = $view;
        $this->data = $data;
        $this->mergeData = array_merge(['theme'=>$this], $mergeData);
        return $this;
    }

    /**
     * Set the theme.
     * @param string $theme
     * @return ThemeContract
     */
    public function theme(?string $theme): ThemeContract
    {
        $this->theme = $theme ?? $this->theme;
        return $this;
    }

    /**
     * Get theme url
     * @param string $url
     * @param bool $secure
     * @return string
     */
    public function url(string $url, $secure = null): string{
        $path = explode('/', ltrim($url, "/"));
        array_unshift($path, $this->theme);
        return url(config('theme.url', 'themes'), $path, $secure);
    }

    /**
     * Get current theme.
     * @return string
     */
    public function getTheme(): string
    {
        return $this->theme ?? config('theme.default');
    }

    /**
     * Get the translation for a given key.
     *
     * @param string $key
     * @param array $replace
     * @param string $locale
     * @return string|array|null
     */
    public function trans($key, array $replace = [], $locale = null)
    {
        return app('theme.translator')->has("{$this->theme}::$key", $locale) ?
            app('theme.translator')->trans("{$this->theme}::$key", $replace, $locale):
            app('translator')->trans($key, $replace, $locale);
    }
}
