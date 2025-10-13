<?php

namespace core;

abstract class Model
{
    public array $fillable = [];
    public array $attributes = [];
    public array $rules = [];
    protected array $errors = [];
    protected array $rules_list = ['required', 'min', 'max', 'email'];
    protected array $messages = [
        'required' => 'The :field_name: field is required',
        'min' => 'The :field_name: field must be a minimum :rule_value: characters',
        'max' => 'The :field_name: field must be a maximum :rule_value: characters',
        'email' => 'Not valid email',
    ];

    public function loadData(): void
    {
        $data = request()->getData();
        foreach ($this->fillable as $v) {
            if (isset($data[$v])) {
                $this->attributes[$v] = $data[$v];
            } else {
                $this->attributes[$v] = '';
            }
        }
    }

    public function validate(): bool
    {
        foreach ($this->attributes as $fields => $value) {
            if (isset($this->rules[$fields])) {
                $this->check([
                    'field_name' => $fields,
                    'value' => $value,
                    'rules' => $this->rules[$fields],
                ]);
            }
        }

        return !$this->hasErrors();
    }

    protected function check(array $field): void
    {
        foreach ($field['rules'] as $rule => $rule_value) {
            if (in_array($rule, $this->rules_list, true)) {
                if (!call_user_func_array([$this, $rule], [$field['value'], $rule_value])) {
                    $this->addError(
                        $field['field_name'],
                        str_replace(
                            [':field_name:', ':rule_value:'],
                            [$field['field_name'], $rule_value],
                            $this->messages[$rule]
                        )
                    );                }
            }
        }
    }

    protected function addError($field_name, $error): void
    {
        $this->errors[$field_name][] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    protected function required($value, $rule_value): bool
    {
        return !empty(trim($value));
    }

    protected function min($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') >= $rule_value;
    }

    protected function max($value, $rule_value): bool
    {
        return mb_strlen($value, 'UTF-8') <= $rule_value;
    }

    protected function email($value, $rule_value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}