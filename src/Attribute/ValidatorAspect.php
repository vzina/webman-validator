<?php
/**
 * ValidatorAspect.php
 * PHP version 7
 *
 * @package webman-demo
 * @author  weijian.ye
 * @contact 891718689@qq.com
 * @link    https://github.com/vzina
 */
declare (strict_types=1);

namespace Vzina\LaravelValidation\Attribute;

use Illuminate\Validation\ValidationException;
use Vzina\Attributes\Ast\ProceedingJoinPoint;
use Vzina\Attributes\Attribute\AspectInterface;

class ValidatorAspect implements AspectInterface
{
    public array $attributes = [
        Validator::class
    ];

    /**
     * @throws ValidationException
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /** @var Validator $attribute */
        $attribute = $proceedingJoinPoint->getAnnotationMetadata()->method[Validator::class];
        if ($attribute->rules) {
            request_validate($attribute->rules, $attribute->messages, $attribute->customAttributes);
        }

        return $proceedingJoinPoint->process();
    }
}