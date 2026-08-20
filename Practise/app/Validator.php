<?php

namespace App;

// A tiny validator: give it the submitted data and a rule string per
// field (like 'required|min:3|max:1000'), get back an array of error
// messages keyed by field name. An empty array means everything's good.
class Validator
{
    public static function validate(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $value = $data[$field] ?? null;

            foreach (explode('|', $ruleString) as $rule) {
                $parameter = null;

                if (str_contains($rule, ':')) {
                    [$rule, $parameter] = explode(':', $rule, 2);
                }

                $error = self::check($rule, $value, $parameter, $field);

                if ($error !== null) {
                    $errors[$field][] = $error;
                }
            }
        }

        return $errors;
    }

    protected static function check(string $rule, mixed $value, ?string $parameter, string $field): ?string
    {
        $value = is_string($value) ? trim($value) : $value;

        return match ($rule) {
            'required' => ($value === null || $value === '')
                ? ucfirst($field) . ' is required.'
                : null,

            'min' => (isset($value) && strlen((string) $value) < (int) $parameter)
                ? ucfirst($field) . " must be at least {$parameter} characters."
                : null,

            'max' => (isset($value) && strlen((string) $value) > (int) $parameter)
                ? ucfirst($field) . " must be no more than {$parameter} characters."
                : null,

            // Unknown rule name — don't block the form over a typo in a rule string.
            default => null,
        };
    }
}
