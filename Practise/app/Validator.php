<?php

namespace App;

// Called by NotesController::create()/edit(); result feeds note.view.php's $errors.
class Validator
{
    // $rules e.g. ['body' => 'required|min:3|max:1000']
    public static function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? null;

            foreach (explode('|', $ruleString) as $rule) {
                [$name, $arg] = array_pad(explode(':', $rule, 2), 2, null);

                $message = match ($name) {
                    'required' => static::required($value),
                    'min' => static::min($value, (int) $arg),
                    'max' => static::max($value, (int) $arg),
                    default => null,
                };

                if ($message) {
                    $errors[$field][] = $message;
                    break; // stop at the first failing rule for this field
                }
            }
        }

        return $errors;
    }

    protected static function required($value): ?string
    {
        return trim((string) $value) === '' ? 'This field is required.' : null;
    }

    protected static function min($value, int $length): ?string
    {
        return strlen(trim((string) $value)) < $length
            ? "This field must be at least {$length} characters."
            : null;
    }

    protected static function max($value, int $length): ?string
    {
        return strlen(trim((string) $value)) > $length
            ? "This field must not exceed {$length} characters."
            : null;
    }
}
