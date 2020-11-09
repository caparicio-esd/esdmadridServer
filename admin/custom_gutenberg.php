<?php

/**
 * custom gutenberg functions
 * Para generar una paleta de colores propios de la escuela!
 * https://developer.wordpress.org/block-editor/developers/themes/theme-support/
 * 
 */
function gutenberg_default_colors()
{
    add_theme_support(
        'editor-color-palette',
        array(
            array(
                'name' => 'White', 
                'slug' => 'white', 
                'color' => '#ffffff'
            )
        )
    );

    add_theme_support(
        'editor-font-sizes',
        array(
            array(
                'name' => 'Normal', 
                'slug' => 'normal', 
                'color' => '16'
            )
        )
    );
}

add_action('init', 'gutenberg_default_colors');
