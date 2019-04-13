<?php


namespace Eslym\EasyTheme;


use Illuminate\Filesystem\Filesystem;
use Illuminate\View\FileViewFinder;
use InvalidArgumentException;

class ThemeViewFinder extends FileViewFinder
{
    /**
     * @var string Path for themes folder.
     */
    protected $themePath;

    /**
     * @var string Current theme.
     */
    protected $theme;

    public function __construct(Filesystem $files, string $themePath, array $extensions = null)
    {
        parent::__construct($files, [], $extensions);
        $this->themePath = $themePath;
    }

    protected function findInPaths($name, $paths)
    {
        $parts = explode(':', $name, 2);

        if(isset($parts[1])){
            $name = $parts[1];
            $this->theme = $parts[0];
        }
        $theme = $this->theme;

        if(!$this->files->exists($this->themePath)){
            throw new InvalidArgumentException("Theme [{$name}] not found.");
        }

        $path = "{$this->themePath}/{$theme}/views";
        foreach ($this->getPossibleViewFiles($name) as $file) {
            if ($this->files->exists($viewPath = $path.'/'.$file)) {
                return $viewPath;
            }
        }

        throw new InvalidArgumentException("View [{$name}] not found in Theme [{$theme}].");
    }
}