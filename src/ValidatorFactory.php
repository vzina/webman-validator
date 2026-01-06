<?php

declare (strict_types=1);

namespace Vzina\LaravelValidation;

use Illuminate\Container\Container as IlluminateContainer;
use Illuminate\Contracts\Translation\Translator as TranslatorInterface;
use Illuminate\Contracts\Validation\Factory as FactoryInterface;
use Illuminate\Validation\DatabasePresenceVerifierInterface;
use Illuminate\Validation\Factory;
use support\Container;
use Webman\Event\Event;

class ValidatorFactory extends Factory
{
    protected static FactoryInterface $instance;

    public static function create()
    {
        if (! isset(static::$instance)) {
            $translator = Container::get(TranslatorInterface::class);
            $validatorFactory = new static($translator, IlluminateContainer::getInstance());

            if (Container::has(DatabasePresenceVerifierInterface::class)) {
                $validatorFactory->setPresenceVerifier(Container::get(DatabasePresenceVerifierInterface::class));
            }

            Event::dispatch(ValidatorFactoryResolved::class, $validatorFactory);

            static::$instance = $validatorFactory;
        }

        return static::$instance;
    }

    public function make(array $data, array $rules, array $messages = [], array $attributes = [])
    {
        return parent::make($data, $rules, $messages, $attributes);
    }
}