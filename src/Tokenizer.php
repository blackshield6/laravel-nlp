<?php

namespace LvlupDev\Nlp;

use LvlupDev\Nlp\Facades\Html;
use LvlupDev\Nlp\Facades\Text;
use LvlupDev\Url\Facades\Url;

class Tokenizer
{
    public string $content = '';
    public array $tokens;

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function tokenize($content, $length = 1): array
    {
        if ($length === 1) {
            return $this->tokenize_simple($content);
        } else {
            return $this->tokenize_multi($content, $length);
        }
    }

    private function tokenize_simple(string $content): array
    {
        $raw = explode(" ", $content);
        $stopWords = \LvlupDev\Nlp\Facades\Nlp::getStopWords();

        return array_filter($raw, function ($token) use ($stopWords) {
            return strlen($token) > 1
                && !is_numeric($token)
                && !in_array($token, $stopWords);
        });
    }

    private function tokenize_multi(string $content, int $length): array
    {
        $raw = explode(" ", $content);
        $stopWords = \LvlupDev\Nlp\Facades\Nlp::getStopWords();

        $tokens = [];

        for ($i = 0; $i < count($raw); $i++) {
            $token = '';
            $current = [];
            for ($j = 0; $j < $length; $j++) {
                if (isset($raw[$i + $j])) {
                    $append = $raw[$i + $j];

                    $current[] = $append;
                }
            }

            $stopScore = 0;
            foreach ($current as $currentToken) {
                if (strlen($currentToken) < 2
                    || is_numeric($currentToken)
                    || in_array($currentToken, $stopWords)) {
                    $stopScore++;
                }
            }

            if ($stopScore < ceil($length / 2)) {
                $token .= implode(' ', $current);
            }

            $token = trim($token);
            if (strlen($token) > 4) {
                $tokens[] = $token;
            }
        }

        return $tokens;
    }
}
