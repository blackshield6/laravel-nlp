<?php

namespace LvlupDev\Nlp;

use LvlupDev\Nlp\Facades\Html;
use LvlupDev\Nlp\Facades\Text;
use LvlupDev\Url\Facades\Url;

class Nlp
{
    public string $content = '';
    private string $lang = 'fr';
    public array $stopWords = [];
    public array $tokens;

    public function setLang($lang): self
    {
        $this->lang = $lang;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getStopwords($lang = 'fr')
    {
        return $this->stopWords = include('stopwords/' . $this->lang . '.php');
    }

    public function getTokens($limit = null, $length = 1): array
    {
        $tokenizer = new Tokenizer();
        $tokens = $tokenizer->tokenize($this->content, $length);

        $tokens = array_count_values($tokens);
        $tokens = array_filter($tokens, function ($score) {
            return $score > 1;
        });

        arsort($tokens);
        return $limit ? array_slice($tokens, 0, $limit) : $tokens;
    }

    public function fromUrl(string $url): self
    {
        $html = Url::fetch($url)->body();
        $content = Html::setHtml($html)->getContent();
        $text = Text::setText($content)->clean();

        $this->setContent($text->getText());

        return $this;
    }

    public function getNgrams($maxLength = 3, $limit = 25): array
    {
        $response = [];
        for ($i = 1; $i <= $maxLength; $i++) {
            $tokens = $this->getTokens($limit, $i);
            $tokens = array_filter($tokens, function ($score) {
                return $score > 1;
            });
            $response[$i] = $tokens;
        }

        return $response;
    }
}
