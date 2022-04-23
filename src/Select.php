<?php

namespace Mailery\Widget\Select;

use Mailery\Widget\Select\SelectAssetBundle;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Form\Widget\Attribute\ChoiceAttributes;

class Select extends ChoiceAttributes
{

    /**
     * @var array
     */
    private array $items = [];

    /**
     * @var AssetManager
     */
    private AssetManager $assetManager;

    /**
     * @param AssetManager $assetManager
     */
    public function __construct(AssetManager $assetManager)
    {
        $this->assetManager = $assetManager;
    }

    /**
     * @param array $value
     * @return self
     */
    public function items(array $value = []): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['multiple'] = $value;
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function taggable(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes['taggable'] = $value;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    protected function run(): string
    {
        $this->assetManager->register(SelectAssetBundle::class);

        $attributes = $this->build($this->attributes);

        $value = $attributes['value'] ?? $this->getAttributeValue();
        unset($attributes['value']);

        if (is_object($value)) {
            throw new \InvalidArgumentException('Select widget value can not be an object.');
        }

        if (is_iterable($value)) {
            $attributes['value'] = array_map('\strval', array_values($value));
        } elseif (null !== $value) {
            $attributes['value'] = $value;
        }

        if ($this->items !== []) {
            $attributes['items'] = json_encode($this->items);
        }

        return CustomTag::name('ui-select')->attributes($attributes)->render();
    }

}
