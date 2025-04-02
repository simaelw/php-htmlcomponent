<?php

namespace Components;

use HtmlComponent;

abstract class BaseComponent {
    protected HtmlComponent $html;
    protected string $tag = 'div';
    protected array $attributes = [];
    protected array $styles = [];
    protected array $classes = [];

    public function __construct() {
        $this->html = HtmlComponent::make($this->tag)
            ->addAttributes($this->attributes)
            ->addStyles($this->styles)
            ->addClasses(...$this->classes);

        if (method_exists($this, 'content')) {
            $this->html->setContent(...(array) $this->content());
        }
    }

    public static function make(): static {
        return new static();
    }

    public function html(): HtmlComponent {
        return $this->html;
    }

    public function render(): string {
        return $this->html->render();
    }

    public function print(): void {
        echo $this->render();
    }

    public function __toString(): string {
        return $this->render();
    }

    protected function content(): array|string|null {
        return null;
    }
}
