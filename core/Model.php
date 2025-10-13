<?php

namespace core;

abstract class Model
{
    public array $fillable = [];
    public array $attributes = [];
    protected array $errors = [];
    protected array $rules_list = ['required', 'min', 'max'];
    protected array $messages = [
        'required' => 'The :field_name: field is required',
        'min' => 'The :field_name: field must be a minimum :rule_value: characters',
        'max' => 'The :field_name: field must be a maximum :rule_value: characters',
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
}