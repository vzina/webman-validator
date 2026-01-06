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

use Vzina\Attributes\Ast\ProceedingJoinPoint;
use Vzina\Attributes\Attribute\AspectInterface;
use Vzina\LaravelValidation\ValidatorException;
use Vzina\LaravelValidation\ValidatorFactory;

class ValidatorAspect implements AspectInterface
{
    public array $attributes = [
        Validator::class
    ];

    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        /** @var Validator $attribute */
        $attribute = $proceedingJoinPoint->getAnnotationMetadata()->method[Validator::class];
        if ($attribute->rules) {
            $validator = ValidatorFactory::create()->make(request_all(), $attribute->rules, $attribute->messages);
            if ($validator->fails()) {
                throw new ValidatorException($validator->errors()->first());
            }
        }

        return $proceedingJoinPoint->process();
    }
}