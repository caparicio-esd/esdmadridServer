<?php

/**
 * 
 * Abstract Page 
 * 
 */
class esd_BE_Page extends esd_BE_Entity
{
    public $accordion;
    public $links;
    public $to_unset_props = ['accordion_ids'];

    public function __construct($post)
    {
        parent::__construct($post);
        $this->accordion = $this->get_accordion($post);
        $this->links = $this->get_links();
        $this->unset_props();
    }

    /**
     * 
     */
    function get_links()
    {
        $links_single = $this->extract_single_links($this->content_raw);
        $this->content_raw = $this->kill_single_links($this->content_raw);
        return $links_single;
    }

    /**
     * 
     */
    public function get_accordion()
    {
        $links = $this->extract_accordion($this->content_raw);
        return $links;
    }
}


/**
 * 
 */
class esd_BE_EscuelaCrece extends esd_BE_Entity
{
    public $to_unset_props = [
        'content',
        'content_text',
        'recent_posts',
        'thumbnail',
        'prev_post',
        'next_post',
        'categories',
        'accordion',
        'links'
    ];

    public function __construct($post)
    {
        parent::__construct($post);
        $this->unset_props();
    }
}


/**
 * 
 */
class esd_BE_PlanEstudios extends esd_BE_EscuelaCrece
{
    public $to_unset_props = [
        'content',
        'content_text',
        'recent_posts',
        'thumbnail',
        'prev_post',
        'next_post',
        'categories',
        'accordion',
        'links',
        'content_raw',
        'summary',
        'meta_fields'
    ];

    public $meta_fields = [
        "landing_fecha_de_inicio_de_la_titulacion",
        "landing_plazas_disponibles_por_curso",
        "landing_creditos_de_la_titulacion_completa",
        "landing_requisitos_de_admision_en_la_titulacion",
        "landing_requisitos_de_admision_en_la_titulacion-alt",
        "landing_plazo_de_inscripcion_para_el_proximo_curso_inicio",
        "landing_plazo_de_inscripcion_para_el_proximo_curso_final",
        "landing_metodologia_de_la_titulacion",
        "landing_duracion_de_la_titulacion",
        "landing_denominacion_de_la_titulacion",
        "landing_presentacion_de_la_titulacion",
        "landing_video_de_la_titulacion",
        "landing_a_quien_va_dirigido",
        "landing_tabla_de_precios",

        "notification-title", 
        "notification-body", 
        "notification-button-text", 
        "notification-button-url",
        "notificacion-active"
    ];

    public function __construct($post)
    {
        $p = get_parent_class(get_class());
        $gp = get_parent_class($p);
        $gp::__construct($post);

        $this->get_meta();
        $this->unset_props();
        $this->template = 'single_plan_estudios';
    }
}
