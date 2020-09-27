<?php

trait Dom_Extractor
{


    /**
     * @function utils_normalize_content
     * 
     * @param {text} $content -> Content
     * @return {dom} $domOut
     * 
     * Cleans all not needed tags, normalizes media src and href
     */
    function utils_normalize_content($content)
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
    function kill_void_tags($dom)
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
    function normalize_media($dom)
    {
        $tagNames = array('img', 'a');

        foreach ($tagNames as $tagName) {
            $tags = $dom->getElementsByTagName($tagName);

            foreach ($tags as $tag) {
                $attrs = $tag->attributes;

                foreach ($attrs as $attr) {
                    if ($attr->name == 'src' || $attr->name == 'href') {
                        $attr->value = htmlentities($attr->value);
                        $attr->value = $this->utils_replace_strange_strings($attr->value);
                        $attr->value = $this->utils_change_url_protocol($attr->value);
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
    function normalize_urls($dom)
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
                        if (strpos($attr->value, $this->api_root) > -1) {
                            $attr->value = htmlentities(str_replace($this->api_root, '', $attr->value));
                        }
                    }
                }
            }
        }
        return $dom;
    }
}
