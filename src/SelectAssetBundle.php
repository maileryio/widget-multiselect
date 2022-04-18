<?php

declare(strict_types=1);

namespace Mailery\Widget\Select;

use Mailery\Web\Assets\VueAssetBundle;
use Yiisoft\Assets\AssetBundle;

class SelectAssetBundle extends AssetBundle
{
    /**
     * {@inheritdoc}
     */
    public ?string $basePath = '@public/assets/@maileryio/widget-select-assets';

    /**
     * {@inheritdoc}
     */
    public ?string $baseUrl = '@assetsUrl/@maileryio/widget-select-assets';

    /**
     * {@inheritdoc}
     */
    public ?string $sourcePath = '@npm/@maileryio/widget-select-assets/dist';

    /**
     * {@inheritdoc}
     */
    public array $js = [
        'main.umd.min.js',
    ];

    /**
     * {@inheritdoc}
     */
    public array $depends = [
        VueAssetBundle::class,
    ];
}
