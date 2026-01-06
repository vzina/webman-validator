<?php

declare (strict_types=1);

namespace Vzina\LaravelValidation;

use Illuminate\Contracts\Translation\Translator as TranslatorInterface;
use Illuminate\Support\Str;

class SymfonyTranslator implements TranslatorInterface
{
    protected string $locale;

    public function __construct(?string $locale = null)
    {
        $this->setLocale($locale ?: locale());
    }

    public function get($key, array $replace = [], $locale = null)
    {
        $locale = $locale ?: $this->locale;
        [$domain, $id] = str_contains($key, '.') ? explode('.', $key, 2) : [null, $key];

        $replaces = [];
        foreach ($replace as $k => $v) {
            $replaces[Str::startsWith($k, ['%', ':']) ? $k : (':' . $k)] = $v;
        }

        return trans($id, $replaces, $domain, $locale);
    }

    public function choice($key, $number, array $replace = [], $locale = null)
    {
        $replace['%count%'] = $number;

        return $this->get($key, $replace, $locale);
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }
}