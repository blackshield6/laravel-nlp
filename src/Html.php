<?php

namespace LvlupDev\Nlp;

use LvlupDev\Url\Facades\Url;

class Html
{
    private string $content = '';
    private string $html;

    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    public function setHtml(string $html)
    {
        $this->html = $html;

        $doc = new \DOMDocument('1.0', 'UTF-8');
        @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $html);
        $this->xpath = new \DOMXPath($doc);

        $this->getContentFromXpath();

        return $this;
    }

    private function getContentFromXpath(): string
    {
        $elements = $this->xpath->query('//head/title|//h1|//h2|//h3|//h4|//strong|//p');
        foreach ($elements as $element) {
            $this->content .= $element->nodeValue . ' ';
        }

        return $this->content;
    }

    public function setContentFromString(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function setContentFromUrl(string $url): self
    {
        $this->content = Url::fetch($url)->body();
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
