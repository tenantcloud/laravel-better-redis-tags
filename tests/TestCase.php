<?php

namespace Tests;

use Illuminate\Foundation\Testing\WithFaker;
use Orchestra\Testbench\TestCase as BaseTestCase;
use TenantCloud\LaravelBetterCache\BetterCacheServiceProvider;

class TestCase extends BaseTestCase
{
	use WithFaker;

	protected function getPackageProviders($app): array
	{
		return [
			BetterCacheServiceProvider::class,
		];
	}

	protected function resolveApplicationConfiguration($app)
	{
		parent::resolveApplicationConfiguration($app);

		$app['config']->set('cache.stores.fail_safe', [
			'driver'   => 'fail_safe',
			'delegate' => [
				'driver' => 'array',
			],
		]);

		$app['config']->set('database.redis.failing_cache', $app['config']->get('database.redis.cache'));
		$app['config']->set('database.redis.failing_cache.host', 'definitely_not_a_real_host');
		$app['config']->set('cache.stores.failing_fail_safe', [
			'driver'   => 'fail_safe',
			'delegate' => [
				'driver'     => 'redis',
				'connection' => 'failing_cache',
			],
		]);
	}
}
