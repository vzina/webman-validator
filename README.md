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

```php
namespace app\Service;

use Vzina\Jsonrpc\Attribute\RpcServer;

#[RpcServer]
class TestService
{
    public function rpc(): array
    {
        return ['test', time()];
    }
}
```

#### 定义客户端

```php
namespace app\Client;

use support\Container;
use Vzina\Jsonrpc\Ast\AbstractProxyService;use Vzina\Jsonrpc\ServiceClient;

class TestService
{
    protected ServiceClient $serviceClient;
    
    public function __construct() 
    {
        $this->serviceClient = new ServiceClient(static::class, [
            'address' => ['http://127.0.0.1:8788'],
            'timeout' => 60,
            'pool' => [
                'max_connections' => 10,
            ]
        ]);
    }

    public function rpc(): array
    {
        return $this->serviceClient->__call(__FUNCTION__, func_get_args());
    }
}

// 或
class TestService extends AbstractProxyService
{
    public function rpc(): array
    {
        return $this->client->__call(__FUNCTION__, func_get_args());
    }
}

// 修改配置文件 rpc_services.php
[
    'name' => TestService::class, // 指定客户端类
    // ... other
]

// 使用
$r = Container::get(TestService::class)->rpc();
var_dump($r);
```

#### 定义自动客户端
```php
namespace app\contracts;

interface TestServiceInterface
{
    public function rpc(): array;
}

// 修改配置文件 rpc_services.php
[
    'auto_services' => app_path('contracts'), // 指定客户端扫描目录
    // ... other
]

// 使用
$r = Container::get(TestServiceInterface::class)->rpc();
var_dump($r);
```
