<?php

declare (strict_types=1);

namespace Vzina\LaravelValidation;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Webman\Http\UploadFile;

class UploadFileDecorator
{
    public static function wrapper(array $params): array
    {
        foreach ($params as $key => &$value) {
            if (is_array($value)) {
                $params[$key] = static::wrapper($value);
                continue;
            }

            if ($value instanceof UploadFile) {
                $value = new class(
                    $value->getRealPath() ?: '',
                    $value->getUploadName() ?? '',
                    $value->getUploadMimeType(),
                    $value->getUploadErrorCode(),
                    false
                ) extends UploadedFile {
                    public function isValid(): bool
                    {
                        return \UPLOAD_ERR_OK === $this->getError();
                    }
                };
            }
        }
        return $params;
    }
}