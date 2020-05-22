<?php

declare(strict_types=1);

use Timber\Timber;
use Timber\PostQuery;

$context          = Timber::context();
$context['posts'] = new PostQuery();
$templates        = [ 'index.twig' ];
Timber::render($templates, $context);
