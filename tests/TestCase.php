<?php declare(strict_types=1);

/*
 * This file is part of Push-Bridge.
 *
 * (c) Jetsung Chan <jetsungchan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
