# Better cache for Laravel

## Fail safe

Laravel's implementation of cache doesn't allow failures - if your Redis dies, your app dies too.
New `fail_safe` driver aims to solve this by catching and logging all exceptions and instead
returning null/false as if the value was simply not found in cache:

```php
// config/cache.php
[
	'fail_safe' => [
		'delegate' => [
			'driver' => 'redis',
			'connection' => 'cache',
			'lock_connection' => 'default',
		]
	]
]

// code
Cache::forever('key', 'value');
// redis died here
Cache::get('key'); // returns null and logs the exception
```
