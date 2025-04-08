<?php
function l(string $key, array $values = []): string
{
    return \App\Localization\Lang::get($key, $values);
}

function lang(string $key, array $values = []): string
{
    return \App\Localization\Lang::get($key, $values);
}

function larray(string $key): array
{
    $value = \App\Localization\Lang::get($key);
    return is_array($value) ? $value : [];
}

function checkperms(array|string $requiredPermissions): bool
{
    return \App\Auth\Permissions::check($requiredPermissions);
}
