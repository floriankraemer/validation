<?php

declare(strict_types=1);

namespace Somnambulist\Components\Validation\Rules;

use Somnambulist\Components\Validation\Rule;
use Somnambulist\Components\Validation\Rules\Contracts\ModifyValue;

/**
 * Class Defaults
 *
 * @package    Somnambulist\Components\Validation\Rules
 * @subpackage Somnambulist\Components\Validation\Rules\Defaults
 */
class Defaults extends Rule implements ModifyValue
{
    protected string $message = 'rule.default_value';
    protected array $fillableParams = ['default'];
    public function check($value): bool
    {
        $this->assertHasRequiredParameters($this->fillableParams);
        return true;
    }

    public function modifyValue($value): mixed
    {
        return $this->isEmptyValue($value) ? $this->parameter('default') : $value;
    }

    protected function isEmptyValue($value): bool
    {
        return false === (new Required())->check($value);
    }
}
