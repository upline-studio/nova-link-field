<?php

namespace Upline\NovaLinkField;

use Closure;
use Laravel\Nova\Fields\Field;

class Link extends Field
{
    private Closure|null $anchorComputedCallback = null;

    private string|null $anchorAttribute = null;

    private string|null $anchorValue = null;

    private Closure|string|null $targetComputedCallback = null;

    private string $targetValue = '_self';

    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-link-field';

    /**
     * @var true
     */
    private bool $asHtml = false;

    public function text(Closure|string $attribute): static
    {
        if ($attribute instanceof Closure) {
            $this->anchorComputedCallback = $attribute;
            $this->anchorAttribute = 'ComputedField';
        } else {
            $this->anchorAttribute = $attribute;
        }

        return $this;
    }

    /**
     * @param  Closure|'_blank'|'_self'  $attribute
     * @return $this
     */
    public function target(Closure|string $attribute): static
    {
        $this->targetComputedCallback = $attribute;

        return $this;
    }

    public function asHtml()
    {
        $this->asHtml = true;

        return $this;
    }

    /**
     * Prepare the field element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), $this->anchorAttributes());
    }

    public function resolve($resource, $attribute = null)
    {
        parent::resolve($resource, $attribute);
        $this->resolveAnchorAttribute($resource);
        $this->resolveTarget($resource);
    }

    public function resolveForDisplay($resource, $attribute = null)
    {
        parent::resolveForDisplay($resource, $attribute);
        if (! $this->anchorValue) {
            $this->resolveAnchorAttribute($resource);
        }
        if (! $this->targetValue) {
            $this->resolveTarget($resource);
        }
    }

    private function resolveAnchorAttribute($resource): void
    {
        $this->resource = $resource;

        $attribute = $this->anchorAttribute;

        if ($attribute === 'ComputedField') {
            $this->anchorValue = call_user_func($this->anchorComputedCallback, $resource);

            return;
        }

        $this->anchorValue = $this->resolveAttribute($resource, $this->anchorAttribute);
    }

    private function anchorAttributes(): array
    {
        return [
            'asHtml' => $this->asHtml,
            'anchorValue' => $this->anchorValue,
            'target' => $this->targetValue,
        ];
    }

    private function resolveTarget($resource)
    {
        if (! $this->targetComputedCallback) {
            return;
        }
        if ($this->targetComputedCallback instanceof Closure) {
            $this->targetValue = call_user_func($this->targetComputedCallback, $resource);

            return;
        }

        $this->targetValue = $this->targetComputedCallback;

    }
}
