<?php

trait Dom_Extractor
{
    use Utils;

    /**
     * @function utils_normalize_content
     * 
     * @param {text} $content -> Content
     * @return {dom} $domOut
     * 
     * Cleans all not needed tags, normalizes media src and href
     */
    public function utils_normalize_content($content)
    {
        $domDocument = new DOMDocument();
        @$domDocument->loadHTML(
            mb_convert_encoding(
                "<div class=\"clean_content\">$content</div>",
                'HTML-ENTITIES'
            ),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $domDocument = $this->kill_void_tags($domDocument);
        $domDocument = $this->normalize_urls($domDocument);
        $domDocument = $this->normalize_media($domDocument);

        $domOut = $domDocument->saveHTML();
        $domOut = html_entity_decode($domOut);

        return $domOut;
    }


    /**
     * @function kill_void_tags
     * 
     * @param {text} $dom -> DOM
     * @return {dom} $domOut
     * 
     * Eliminates void tags
     */
    public function kill_void_tags($dom)
    {
        $tagsToRemove = array();
        $tagNames = array('div', 'p', 'h1', 'h2', 'h3', 'h4', 'span');

        foreach ($tagNames as $tagName) {
            $tags = $dom->getElementsByTagName($tagName);
            foreach ($tags as $tag) {
                if (
                    htmlentities($tag->textContent) == '&nbsp;' ||
                    htmlentities($tag->textContent) == '&nbsp;&nbsp;'
                ) {
                    array_push($tagsToRemove, $tag);
                }
            }
        }

        foreach ($tagsToRemove as $tag) {
            if ($tag->parentNode) {
                $tag->parentNode->removeChild($tag);
            }
        }
        return $dom;
    }


    /**
     * @function normalize_media
     * 
     * @param {dom} $dom -> DOM
     * @return {text} $domOut
     * 
     * Normalize media srcs...
     */
    public function normalize_media($dom)
    {
        $tagNames = array('img', 'a');

        foreach ($tagNames as $tagName) {
            $tags = $dom->getElementsByTagName($tagName);

            foreach ($tags as $tag) {
                $attrs = $tag->attributes;

                foreach ($attrs as $attr) {
                    if (
                        $attr->name == 'src' ||
                        $attr->name == 'srcset' ||
                        $attr->name == 'href'
                    ) {
                        $attr->value = htmlentities($attr->value);
                        $attr->value = $this->utils_replace_strange_strings($attr->value);
                        $attr->value = $this->utils_change_url_protocol($attr->value);
                    }
                    if (
                        $attr->name == 'src' ||
                        $attr->name == 'srcset'
                    ) {
                        $attr->value = $this->utils_static_assets_url($attr->value);
                    }
                }
            }
        }
        return $dom;
    }


    /**
     * @function normalize_urls
     * 
     * @param {dom} $dom -> dom
     * @return {dom} $dom
     * 
     * Normalize hrefs
     */
    public function normalize_urls($dom)
    {
        $tagNames = array('a');

        foreach ($tagNames as $tagName) {
            $tags = $dom->getElementsByTagName($tagName);

            foreach ($tags as $tag) {
                $attrs = $tag->attributes;

                foreach ($attrs as $attr) {
                    if (
                        ($attr->name == 'href' && !strpos($attr->value, 'uploads')) ||
                        ($attr->name == 'data-saferedirecturl' && !strpos($attr->value, 'uploads'))
                    ) {
                        if (strpos($attr->value, esd_BE__BasicData::$api_root) > -1) {
                            $attr->value = htmlentities(str_replace(esd_BE__BasicData::$api_root, '', $attr->value));
                        }
                    }
                }
            }
        }
        return $dom;
    }


    /**
     * @function normalize_media
     * 
     * @param {dom} $dom -> DOM
     * @return {text} $domOut
     * 
     * Normalize media srcs...
     */
    public function extract_links($dom)
    {
        $tagNames = array('a');
        $linkTypes = array('pdf', 'doc', 'docx');
        $linksTag = [];
        $links = [];

        // extract
        foreach ($tagNames as $tagName) {
            $tags = $dom->getElementsByTagName($tagName);

            foreach ($tags as $tag) {
                $linkTag = new stdClass();
                $attrs = $tag->attributes;

                foreach ($attrs as $attr) {
                    if (
                        $attr->name == 'href'
                    ) {
                        $attr->value = htmlentities($attr->value);
                        $attr->value = $this->utils_replace_strange_strings($attr->value);
                        $attr->value = $this->utils_change_url_protocol($attr->value);
                        $attr->value = $this->utils_static_assets_url($attr->value);

                        $linkTag->url = $attr->value;
                        $linkTag->title = $tag->nodeValue;
                        array_push($linksTag, $linkTag);
                    }
                }
            }
        }

        //filter
        foreach ($linksTag as $linkTag) {
            foreach ($linkTypes as $linkType) {
                if (preg_match('/(.*?)\.(' . $linkType .  ')$/', $linkTag->url)) {
                    
                    $link = new stdClass();
                    $link->type = $linkType;
                    $link->url = $linkTag->url;
                    $link->title = trim($linkTag->title);
                    
                    array_push($links, $link);
                }
            }
        }
    
        return sizeof($links) > 0 ? $links : null;
    }
}
