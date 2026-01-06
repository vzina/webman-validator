<?php

declare (strict_types=1);

namespace Vzina\LaravelValidation;

use Illuminate\Contracts\Translation\Translator as TranslatorInterface;

class SymfonyTranslator implements TranslatorInterface
{
    public function get($key, array $replace = [], $locale = null)
    {
        $locale = $locale ?: $this->getLocale();
        [$domain, $id] = str_contains($key, '.') ? explode('.', $key, 2) : [null, $key];

        $replaces = [];
        foreach ($replace as $k => $v) {
            $replaces[in_array($k[0], ['%', ':']) ? $k : ":{$k}"] = $v;
        }

        $message = trans($id, $replaces, $domain, $locale);

        return $message === $id ? $key : $message;
    }

    public function choice($key, $number, array $replace = [], $locale = null)
    {
        if (is_countable($number)) {
            $number = count($number);
        }
        $replace['count'] = $number;

        return $this->get($key, $replace, $locale);
    }

    public function getLocale()
    {
        return locale();
    }

    public function setLocale($locale)
    {
        locale($locale);
    }
}