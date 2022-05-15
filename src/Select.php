<?php

namespace Mailery\Widget\Select;

use Mailery\Widget\Select\SelectAssetBundle;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Form\Widget\Attribute\ChoiceAttributes;
use Yiisoft\Form\Widget\Attribute\PlaceholderInterface;

class Select extends ChoiceAttributes implements PlaceholderInterface
{

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
        $new->attributes['items'] = json_encode($value);
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function placeholder(string $value): self
    {
        $new = clone $this;
        $new->attributes['placeholder'] = $value;
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes[':multiple'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function taggable(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes[':taggable'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function clearable(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes[':clearable'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function searchable(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes[':searchable'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function closeOnSelect(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes[':close-on-select'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function deselectFromDropdown(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes[':deselect-from-dropdown'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function disable(bool $value = true): self
    {
        $new = clone $this;
        $new->attributes[':disabled'] = json_encode($value);
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

        $attributes['class-name'] = $attributes['class'] ?? '';

        unset($attributes['class']);

        return CustomTag::name('ui-select')->attributes($attributes)->render();
    }

}
