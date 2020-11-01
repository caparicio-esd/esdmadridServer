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
     * @function extract_links
     * 
     * @param {dom} $dom -> DOM
     * 
     * Extract links from text
     */
    public function extract_links($content)
    {
        $domDocument = new DOMDocument();
        @$domDocument->loadHTML(
            mb_convert_encoding($content, 'HTML-ENTITIES'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $tagNames = array('a');
        $linkTypes = array('pdf', 'doc', 'docx');
        $linksTag = [];
        $links = [];

        // extract
        foreach ($tagNames as $tagName) {
            $tags = $domDocument->getElementsByTagName($tagName);

            foreach ($tags as $tag) {
                $linkTag = new stdClass();
                $attrs = $tag->attributes;

                foreach ($attrs as $attr) {
                    if (
                        $attr->name == 'href'
                    ) {
                        $attr->value = htmlentities($attr->value);
                        $attr->value = $this->utils_replace_strange_strings($attr->value);
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

    /**
     * @function extract_accordion
     * 
     * @param {dom} $dom -> DOM
     * 
     * Extract links from text
     */
    public function extract_accordion($content)
    {
        $domDocument = new DOMDocument();
        @$domDocument->loadHTML(
            mb_convert_encoding($content, 'HTML-ENTITIES'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $accordion_sections = [];
        $accordion_section = null;
        $accordion_content = null;
        $tags = $domDocument->childNodes[0]->childNodes;

        foreach ($tags as $tag) {
            if ($tag->nodeName == 'h2') {
                if ($accordion_section != null && $accordion_content != null) {
                    
                    $accordion_section->title = $tag->nodeValue; 
                    $accordion_section->content = html_entity_decode($accordion_content->saveHTML());
                    $accordion_section->content = $this->utils_replace_strange_strings($accordion_section->content);
                    $accordion_section->content = $this->utils_static_assets_url($accordion_section->content);
                    $accordion_section->links = $this->extract_links($accordion_section->content);
                    array_push($accordion_sections, $accordion_section);
                }
                $accordion_section = new stdClass();
                $accordion_content = new DOMDocument();
                $accordion_content->loadHTML(mb_convert_encoding("<div class=\"accordion_content\"></div>", 'HTML-ENTITIES'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
            
            } else {
                if ($accordion_content) {
                    if ($tag instanceof DOMElement) {
                        $node = $accordion_content->importNode($tag, true);
                        $accordion_content->documentElement->appendChild($node);
                    }                    
                }
            }
        }

        return $accordion_sections;
    }
}
