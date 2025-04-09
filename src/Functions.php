<?php

function lang(string $key, array $values = []): string
{
    return \App\Localization\Lang::get($key, $values);
}

function _l(string $key, array $values = []): string
{
    return lang($key, $values);
}

function larray(string $key): array
{
    $value = \App\Localization\Lang::get($key);
    return is_array($value) ? $value : [];
}

function _la(string $key): array
{
    return larray($key);
}

function checkperms(array|string $requiredPermissions): bool
{
    return \App\Auth\Permissions::check($requiredPermissions);
}
