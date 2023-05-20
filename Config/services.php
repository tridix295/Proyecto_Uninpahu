<?php

use Illuminate\Contracts\Database\Eloquent\Builder;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Illuminate\Validation\Factory as validation;

function app() {
    $builder =  new ContainerBuilder();

    $builder->register(validation::class,validation::class);

    $builder->compile();
}
app();

?>