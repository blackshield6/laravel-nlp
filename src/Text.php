<?php

namespace LvlupDev\Nlp;

class Text
{
    private string $text = '';

    public function setText(string $text): self
    {
        $this->text = $text;
        return $this;
    }

    private function removePunct(): self
    {
        $forbiddenChars = ',.;:!?()[]{}\'"«»“”|–—’‘…©¯ツ→✓®`‘’·/';
        $remove = mb_str_split($forbiddenChars);

        $this->text = str_replace($remove, ' ', $this->text);

        return $this;
    }

    private function removeSpaces(): self
    {
        while (str_contains($this->text, '  ')) {
            $this->text = str_replace('  ', ' ', $this->text);
        }

        return $this;
    }

    public function clean(): self
    {
        $this->text = str_replace(["\n", "\r", "\t"], '', $this->text);
        $this->text = mb_strtolower($this->text);
        $this->text = trim($this->text);

        $this->removePunct();
        $this->removeSpaces();

        return $this;
    }

    public function getText()
    {
        return $this->text;
    }
}
