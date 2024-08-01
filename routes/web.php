<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::any(
    '/{any}',
    static fn () => view('index')
)->where(['any' => '.*']);
