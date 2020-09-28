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
    public static $is_production;
    public static $is_migrated;

    public static $api_static_assets;
    public static $origin_statics_there;
    public static $static_assets;

    public static $flag_name = 'ui-flag';
    public static $flag_options = [
        "single_no_sidebar",
        "single_sidebar",
        "porfolio_home",
        "porfolio_single",
        "home",
        "template_escuela_crece"
    ];
    public static $template_collection;

    public function __construct()
    {
        self::$root = site_url();
        self::$api_root = self::$root . '/wp-json/esd/v1/';
        self::$is_production = false;
        self::$is_migrated = false;

        self::$api_static_assets = self::$root . '/wp-content/uploads/';;
        self::$origin_statics_there = 'https://esdmadrid.es/esdmadrid_2.0/wp-content/uploads/';
        self::$static_assets = self::$is_migrated ? self::$api_static_assets : self::$origin_statics_there;

        self::$template_collection = $this->get_post_template_field(null, self::$flag_name);
    }
}

new esd_BE__BasicData();

