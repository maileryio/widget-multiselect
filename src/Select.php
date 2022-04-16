<?php

namespace Mailery\Widget\Select;

use Mailery\Widget\Select\SelectAssetBundle;
use Yiisoft\Assets\AssetManager;
use Yiisoft\Html\Html;
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
     * {@inheritdoc}
     */
    protected function run(): string
    {
        $this->assetManager->register(SelectAssetBundle::class);

        $attributes = $this->build($this->attributes);

        return (string) Html::tag(
            'ui-select',
            '',
            []
        );
    }

}
