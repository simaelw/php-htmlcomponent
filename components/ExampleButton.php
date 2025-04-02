<?php

namespace Components;

use HtmlComponent;

class ExampleButton extends BaseComponent {
    protected string $tag = 'button';
    protected array $attributes = ['type' => 'button'];
    protected array $classes = ['btn', 'btn-primary'];

    protected function content(): array|string|null {
        return [
            HtmlComponent::make('span')->setContent('Press Me')->addClasses('btn-text')
        ];
    }
}
