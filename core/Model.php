<?php

namespace core;

abstract class Model
{
    protected string $table = '';
    public array $fillable = [];
    public array $attributes = [];
    public array $rules = [];
    public array $labels = [];
    protected array $errors = [];
    protected array $rules_list = ['required', 'min', 'max', 'email', 'unique', 'extension', 'size'];
    protected array $messages = [
        'required' => ':field_name: field is required',
        'min' => ':field_name: field must be a minimum :rule_value: characters',
        'max' => ':field_name: field must be a maximum :rule_value: characters',
        'email' => 'Not valid :field_name:',
        'unique' => ':field_name: is already taken',
        'extension' => 'File :field_name: extension does not match. Allowed :rule_value:',
        'size' => 'File :field_name: is to large. Allowed :rule_value: bytes',
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
            if (in_array($rule, $this->rules_list, true)
                && !$this->$rule($field['value'], $rule_value)) {
                $this->addError(
                    $field['field_name'],
                    str_replace(
                        [':field_name:', ':rule_value:'],
                        [$this->labels[$field['field_name']] ?? $field['field_name'], $rule_value],
                        $this->messages[$rule]
                    )
                );                }
        }
        /*foreach ($field['rules'] as $rule => $rule_value) {
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
        }*/
    }

    protected function addError($field_name, $error): void
    {
        $this->errors[$field_name][] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function listErrors(): string
    {
        $output = '<ul class="list-unstyled">';
        foreach ($this->errors as $fields) {
            foreach ($fields as $error) {
                $output .= "<li>{$error}</li>";
            }
        }
        $output .= '</ul>';
        return $output;
    }

    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    protected function required($value, $rule_value): bool
    {
        if (is_string($value)) {
            $value = trim($value);
        }
        if (is_array($value)) {
            if (empty($value['name'])) {
                return false;
            }
        }

        return !empty($value);
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

    protected function unique($value, $rule_value): bool
    {
        $data = explode(':', $rule_value);
        $attributes = [$data[1] => $value];

        return !db()->selectWhere($data[0], $attributes);
    }

    public function extension($value, $rule_value): bool
    {
        if (empty($value['name'])) {
            return true;
        }
        $fileExtension = get_file_extension($value['name']);

        return in_array($fileExtension, explode('|', $rule_value), true);
    }

    public function size($value, $rule_value): bool
    {
        if (empty($value['size'])) {
            return true;
        }

        return $value['size'] <= $rule_value;
    }
}