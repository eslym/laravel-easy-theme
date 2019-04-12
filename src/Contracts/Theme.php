<?php


namespace Eslym\EasyTheme\Contracts;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

interface Theme
{
    /**
     * Compile and render the view.
     * @return View
     */
    public function render(): View;

    /**
     * Return response.
     * @param int $status
     * @param array $headers
     * @return Response
     */
    public function response(int $status = 200, array $headers = []): Response;

    /**
     * Set view.
     * @param string[]|string $view
     * @param array|Arrayable $data
     * @param array $mergeData
     * @return Theme
     */
    public function view($view, $data = [], array $mergeData = []): Theme;

    /**
     * Set the theme.
     * @param string $theme
     * @return Theme
     */
    public function theme(?string $theme): Theme;

    /**
     * Get theme url
     * @param string $url
     * @param bool $secure
     * @return string
     */
    public function url(string $url, $secure = null): string;

    /**
     * Get current theme.
     * @return string
     */
    public function getTheme(): string;
}