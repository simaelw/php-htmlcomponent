<?php

function component(string $name): ?Components\BaseComponent {
    $class = "Components\\" . ucfirst($name);
    
    if (class_exists($class)) {
        return $class::make();
    }

    return null;
}

function html(string $tag): HtmlComponent {
    return HtmlComponent::make($tag);
}