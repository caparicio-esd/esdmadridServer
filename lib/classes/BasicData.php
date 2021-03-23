<?php

/**
 * Clase que almacena propiedades estáticas para toda la aplicación
 *
 */



class esd_BE__BasicData
{
    use Flags;

    public static $root;
    public static $api_root;
    public static $is_local;

    public static $api_static_assets;
    public static $production_statics;
    public static $final_static_assets;

    public static $flag_name = 'ui-flag';
    public static $flag_options = [
        "single_no_sidebar",
        "single_sidebar",
        "porfolio_home",
        "porfolio_single",
        "home",
        "template_escuela_crece",
        "template_contacto",
        "template_empresas",
        "template_convenio"
    ];
    public static $template_collection;

    public function __construct()
    {
        self::$root = site_url();
        self::$api_root = self::$root . '/wp-json/esd/v1/';
        self::$is_local = true;

        self::$api_static_assets = self::$root . '/wp-content/uploads/';
        self::$production_statics = 'https://admin-dev.esdmadrid.es' . '/wp-content/uploads/';
        self::$final_static_assets = self::$is_local ? self::$production_statics : self::$api_static_assets;

        self::$template_collection = $this->get_post_template_field(null, self::$flag_name);
    }
}

new esd_BE__BasicData();

