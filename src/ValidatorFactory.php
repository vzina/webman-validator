<?php

declare (strict_types=1);

namespace Vzina\LaravelValidation;

use Illuminate\Container\Container;
use Illuminate\Contracts\Validation\Factory as FactoryInterface;
use Illuminate\Validation\Factory;
use Vzina\LaravelValidation\Translation\SymfonyTranslator;

class ValidatorFactory extends Factory
{
    protected static FactoryInterface $instance;

    public static function create(): static
    {
        return static::$instance ??= new static(new SymfonyTranslator(), Container::getInstance());
    }

    public function make(array $data, array $rules, array $messages = [], array $attributes = [])
    {
        $this->getTranslator()->setLocale(locale());

        return parent::make($data, $rules, $messages, $attributes);
    }
}