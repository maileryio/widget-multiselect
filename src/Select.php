<?php

namespace Mailery\Widget\Select;

use Mailery\Widget\Select\SelectAssetBundle;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Form\Field\Base\InputField;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesTrait;
use Yiisoft\Form\Field\Base\EnrichmentFromRules\EnrichmentFromRulesInterface;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassTrait;
use Yiisoft\Form\Field\Base\ValidationClass\ValidationClassInterface;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderInterface;
use Yiisoft\Form\Field\Base\Placeholder\PlaceholderTrait;

class Select extends InputField implements EnrichmentFromRulesInterface, ValidationClassInterface, PlaceholderInterface
{

    use EnrichmentFromRulesTrait;
    use ValidationClassTrait;
    use PlaceholderTrait;

    /**
     * @param AssetManager $assetManager
     */
    public function __construct(
        private AssetManager $assetManager
    ) {}

    /**
     * @param array $value
     * @return self
     */
    public function optionsData(array $value = []): self
    {
        $new = clone $this;
        $new->inputAttributes['items'] = json_encode($value, JSON_FORCE_OBJECT);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function multiple(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes[':multiple'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function taggable(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes[':taggable'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function clearable(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes[':clearable'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function searchable(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes[':searchable'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function closeOnSelect(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes[':close-on-select'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function deselectFromDropdown(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes[':deselect-from-dropdown'] = json_encode($value);
        return $new;
    }

    /**
     * @param bool $value
     * @return self
     */
    public function disable(bool $value = true): self
    {
        $new = clone $this;
        $new->inputAttributes[':disabled'] = json_encode($value);
        return $new;
    }

    /**
     * @param string $value
     * @return self
     */
    public function inputCallback(string $value): self
    {
        $new = clone $this;
        $new->inputAttributes['@input-callback'] = $value;
        return $new;
    }

    /**
     * {@inheritdoc}
     */
    protected function generateInput(): string
    {
        $this->assetManager->register(SelectAssetBundle::class);

        $attributes = $this->getInputAttributes();

        $value = $attributes['value'] ?? $this->getFormAttributeValue();
        unset($attributes['value']);

        if (is_object($value)) {
            throw new \InvalidArgumentException('Select widget value can not be an object.');
        }

        if (is_iterable($value)) {
            $attributes['value'] = array_map('\strval', array_values($value));
        } elseif (is_bool($value)) {
            $attributes['value'] = (int) $value;
        } elseif (null !== $value) {
            $attributes['value'] = $value;
        }

        $attributes['name'] ??= $this->getInputName();
        $attributes['class-name'] = implode(' ', $attributes['class'] ?? '');
        unset($attributes['class']);

        return CustomTag::name('ui-select')->attributes($attributes)->render();
    }

}
