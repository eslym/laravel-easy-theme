<?php

use Eslym\EasyTheme\Facades\Theme;

/**
 * @param string $theme
 * @return \Eslym\EasyTheme\Contracts\Theme
 */
function theme($theme = null){
    return Theme::theme($theme);
}