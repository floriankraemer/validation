<?php

declare(strict_types=1);

namespace Somnambulist\Components\Validation\Rules;

use Somnambulist\Components\Validation\Contracts\MimeTypeGuesser as MimeTypeGuesserContract;
use Somnambulist\Components\Validation\MimeTypeGuesser;
use Somnambulist\Components\Validation\Rule;
use Somnambulist\Components\Validation\Rules\Behaviours\CanValidateFiles;

/**
 * Class Mimes
 *
 * @package    Somnambulist\Components\Validation\Rules
 * @subpackage Somnambulist\Components\Validation\Rules\Mimes
 */
class Mimes extends Rule
{
    use CanValidateFiles;


    protected string $message = 'rule.mimes';
    protected MimeTypeGuesserContract $guesser;
    public function __construct(MimeTypeGuesserContract $guesser = null)
    {
        $this->guesser = $guesser ?? new MimeTypeGuesser();
    }

    public function fillParameters(array $params): self
    {
        $this->types($params);
        return $this;
    }

    public function types($types): self
    {
        if (is_string($types)) {
            $types = explode(',', $types);
        }

        $this->params['allowed_types'] = $types;
        return $this;
    }

    public function check($value): bool
    {
        $allowedTypes = $this->parameter('allowed_types');
// below is Required rule job
        if (!$this->isValueFromUploadedFiles($value) || $value['error'] == UPLOAD_ERR_NO_FILE) {
            return true;
        }

        if (!$this->isUploadedFile($value)) {
            return false;
        }

        // just make sure there is no error
        if ($value['error']) {
            return false;
        }

        if (!empty($allowedTypes) && !in_array($this->guesser->getExtension($value['type']), $allowedTypes)) {
            return false;
        }

        return true;
    }
}
