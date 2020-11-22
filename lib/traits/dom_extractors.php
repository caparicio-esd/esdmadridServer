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

        $domOut = $this->utils_inner_anchors($domOut);
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

        return sizeof($links) > 0 ? $links : [];
    }


    /**
     * @function extract_single_links
     * 
     * @param {dom} $dom -> DOM
     * 
     * Extract single_link elements from text
     */
    function kill_single_links($content)
    {
        $domDocument = new DOMDocument();
        @$domDocument->loadHTML(
            mb_convert_encoding($content, 'HTML-ENTITIES'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $tagsToRemove = array();
        $tagNames = array('div', 'p', 'a');

        foreach ($tagNames as $tagName) {
            $tags = $domDocument->getElementsByTagName($tagName);
            foreach ($tags as $tag) {

                if (
                    $tag->getAttribute('class') == 'single_link' 
                    //|| 
                    //(
                        //$tag->childNodes->length == 1 &&
                        //$tag->childNodes[0]->tagName == 'a'
                    //) ||
                    //strpos($tag->getAttribute('href'), '.pdf') !== false
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

        return $domDocument->saveHTML();
    }


    /**
     * @function extract_single_links
     * 
     * @param {dom} $dom -> DOM
     * 
     * Extract single_link elements from text
     */
    function extract_single_links($content)
    {
        $domDocument = new DOMDocument();
        @$domDocument->loadHTML(
            mb_convert_encoding($content, 'HTML-ENTITIES'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $tagNames = array('div', 'p');
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
                        $attr->name == 'class' && 
                        $attr->value == 'single_link'
                    ) {

                        $link_container = $tag;
                        $link_items = $link_container->getElementsByTagName('a');
                        

                        foreach ($link_items as $link_item) {
                            $linkTag->url = htmlentities($link_item->getAttribute('href'));
                            $linkTag->url = $this->utils_replace_strange_strings($linkTag->url);
                            $linkTag->url = $this->utils_static_assets_url($linkTag->url);
                            //$linkTag->title = htmlentities($link_item->nodeValue);
                            $linkTag->title = $link_item->nodeValue;
                            array_push($linksTag, $linkTag);
                        }
                    }
                }
            }
        }

        //filter
        foreach ($linksTag as $linkTag) {
            $link = new stdClass();
            $link->title = trim($linkTag->title);
            $link->url = $linkTag->url;
            
            foreach ($linkTypes as $linkType) {
                $link->type = preg_match('/(.*?)\.(' . $linkType .  ')$/', $linkTag->url) ? $linkType : '';
            }
            array_push($links, $link);
        }

        return sizeof($links) > 0 ? $links : [];
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
                    $accordion_section->content = html_entity_decode($accordion_content->saveHTML());
                    $accordion_section->content = $this->utils_replace_strange_strings($accordion_section->content);
                    $accordion_section->content = $this->utils_static_assets_url($accordion_section->content);

                    $links_a = $this-> extract_single_links($accordion_section->content);
                    //$links_b = $this->extract_links($accordion_section->content);

                    //$accordion_section->links = array_merge($links_a, $links_b);
                    $accordion_section->links = $links_a;

                    $accordion_section->content = $this->kill_single_links($accordion_section->content);
                    array_push($accordion_sections, $accordion_section);
                }
                $accordion_section = new stdClass();
                $accordion_section->title = $tag->nodeValue;
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


    /**
     * @function extract_accordion
     * 
     * @param {dom} $dom -> DOM
     * 
     * Extract links from text
     */
    public function extract_summary($content)
    {
        $domDocument = new DOMDocument();
        @$domDocument->loadHTML(
            mb_convert_encoding($content, 'HTML-ENTITIES'),
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );

        $paragraph_section = null;
        $paragraph_sections = [];
        $paragraph_texts = [];
        $tags = $domDocument->childNodes[0]->childNodes;

        foreach ($tags as $tag) {
            if ($tag->nodeName == 'p' || $tag->nodeName == 'div') {
                $paragraph_content = new DOMDocument();
                $paragraph_section = new stdClass();
                $paragraph_content->loadHTML(mb_convert_encoding("<div class=\"summary\"></div>", 'HTML-ENTITIES'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                $node = $paragraph_content->importNode($tag, true);
                $paragraph_content->documentElement->appendChild($node);

                $paragraph_section->content = html_entity_decode($paragraph_content->saveHTML());
                $paragraph_section->content = $this->utils_replace_strange_strings($paragraph_section->content);
                $paragraph_section->content = $this->utils_static_assets_url($paragraph_section->content);
                array_push($paragraph_sections, $paragraph_section);
                array_push($paragraph_texts, $paragraph_content->textContent);
            }
        }

        if (sizeof($paragraph_texts) > 0) {
            return $paragraph_texts[0];
        } else {
            return "";
        }
    }
}
