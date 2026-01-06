<?php
/**
 * Validator.php
 * PHP version 7
 *
 * @package webman-demo
 * @author  weijian.ye
 * @contact 891718689@qq.com
 * @link    https://github.com/vzina
 */
declare (strict_types=1);

namespace Vzina\LaravelValidation\Attribute;

use Attribute;
use Vzina\Attributes\Attribute\AbstractAttribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Validator extends AbstractAttribute
{
    public function __construct(
        public array $rules = [],
        public array $messages = []
    ) {
    }
}