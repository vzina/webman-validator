# Webman Validator

### 简介
该组件将 **Laravel** 强大的验证功能引入 **webman** 框架中，提供了完整的数据验证解决方案。

所有方法和配置与 **Laravel** 几乎一致，因此使用方式可完全参考 [Laravel Validation 文档](https://laravel.com/docs/validation)。

### 基本使用

```php
use Vzina\LaravelValidation\ValidatorFactory;

$validator = ValidatorFactory::create()->make(request_all(), [
    'title' => 'required|unique:posts|max:255',
    'file' => 'required|file|image',
    'body' => 'required',
]);

if ($validator->fails()) {
    return json($validator->errors()->first());
}
```

### 注解使用

```php
use Vzina\Attributes\Attribute\Route\Controller;
use Vzina\Attributes\Attribute\Route\GetMapping;
use Vzina\Attributes\Attribute\Route\PostMapping;
use Vzina\LaravelValidation\Attribute\Validator;

#[Controller(prefix: '/api')]
class TestController
{
    #[GetMapping(path: ''), Validator([
        'a' => 'required|int',
        'b' => 'required|foo',
    ])]
    public function index()
    {
        return 'index:' . time();
    }

    #[PostMapping(path: 'upload'), Validator([
        'file' => 'required|file|image',
    ])]
    public function upload()
    {
        return 'upload:' . time();
    }
}
```


### 扩展规则

```php

use Illuminate\Validation\Validator;
use Vzina\Attributes\Attribute\Listener;
use Vzina\LaravelValidation\ValidatorFactory;
use Vzina\LaravelValidation\ValidatorFactoryResolved;

#[Listener(event: ValidatorFactoryResolved::class)]
class ValidatorListener
{
    public function handle(ValidatorFactory $factory)
    {
        $factory->extend('foo', function (string $attribute, mixed $value, array $parameters, Validator $validator): bool {
            return $value == 'foo';
        });

        // 当创建一个自定义验证规则时，你可能有时候需要为错误信息定义自定义占位符这里扩展了 :foo 占位符
        $factory->replacer('foo', function (string $message, string $attribute, string $rule, array $parameters): array|string {
            return str_replace(':foo', $attribute, $message);
        });
    }
}
```