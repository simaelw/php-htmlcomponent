<?php
class HtmlComponent {
    protected string $tag;
    protected array $attributes = [];
    protected array $classes = [];
    protected array $styles = [];
    protected ?string $content = null;
    protected bool $forceSelfClosing = false;
    protected static array $selfClosingTags = ['input', 'br', 'img', 'hr', 'meta', 'link'];

    public function __construct(string $tag) {
        $this->tag = strtolower($tag);
    }

    public static function make(string $tag): static {
        return new static($tag);
    }

    public function addAttributes(string|array ...$attributes): self {
        foreach ($attributes as $attribute) {
            if (is_array($attribute)) {
                foreach ($attribute as $key => $value) {
                    if (is_int($key)) {
                        $this->attributes[$value] = null;
                    } else {
                        $this->attributes[$key] = $value;
                    }
                }
            } else {
                $this->attributes[$attribute] = null;
            }
        }
        return $this;
    }

    public function addClasses(string ...$classes): self {
        $this->classes = array_merge($this->classes, $classes);
        return $this;
    }

    public function addStyles(string|array $property, ?string $value = null): self {
        if (is_array($property)) {
            foreach ($property as $prop => $val) {
                $this->styles[$prop] = $val;
            }
        } else {
            $this->styles[$property] = $value;
        }
        return $this;
    }

    public function setContent(string|self ...$contents): self {
        $this->content = implode('', array_map(fn($c) => $c instanceof self ? $c->render() : $c, $contents));
        return $this;
    }

    public function appendContent(string|self ...$contents): self {
        $newContent = implode('', array_map(fn($c) => $c instanceof self ? $c->render() : $c, $contents));
        $this->content .= $newContent;
        return $this;
    }

    public function prependContent(string|self ...$contents): self {
        $newContent = implode('', array_map(fn($c) => $c instanceof self ? $c->render() : $c, $contents));
        $this->content = $newContent . $this->content;
        return $this;
    }    

    protected function renderAttributes(): string {
        $attributes = $this->attributes;
        if (!empty($this->classes)) {
            $attributes['class'] = implode(' ', $this->classes);
        }
        if (!empty($this->styles)) {
            $attributes['style'] = implode('; ', array_map(fn($k, $v) => "$k: $v", array_keys($this->styles), $this->styles));
        }
        return implode(' ', array_map(fn($k, $v) => "$k=\"$v\"", array_keys($attributes), $attributes));
    }

    public function selfClosing(bool $value = true): self {
        $this->forceSelfClosing = $value;
        return $this;
    }

    protected function isSelfClosing(): bool {
        if ($this->forceSelfClosing) {
            return true;
        }
        
        return in_array($this->tag, self::$selfClosingTags, true);
    }

    public function render(): string {
        $attributes = $this->renderAttributes();
        $attributes = $attributes ? ' ' . $attributes : '';
        if ($this->isSelfClosing()) {
            return "<{$this->tag}{$attributes} />";
        }
        return "<{$this->tag}{$attributes}>{$this->content}</{$this->tag}>";
    }

    public function print(): void {
        echo $this->render();
    }

    public function __toString(): string {
        return $this->render();
    }
}
