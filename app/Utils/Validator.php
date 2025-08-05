<?php
namespace App\Utils;

use App\Core\Database;
use App\Utils\Flash;
use App\Utils\Lang;

class Validator
{
    protected array $data;
    protected array $rules;
    protected array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function validate(): bool
    {
        foreach ($this->rules as $field => $ruleList) {
            $rules = explode('|', $ruleList);
            $value = trim($this->data[$field] ?? '');

            foreach ($rules as $rule) {
                [$ruleName, $param] = array_pad(explode(':', $rule, 2), 2, null);

                if ($ruleName === 'required' && $value === '') {
                    $this->addError($field, Lang::t('validation.field_is_required', ['field' => $field]));
                }

                if ($ruleName === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($field, Lang::t('validation.invalid_email'));
                }

                if ($ruleName === 'min' && strlen($value) < (int)$param) {
                    $this->addError($field, Lang::t('validation.min_length', ['min' => $param]));
                }

                if ($ruleName === 'max' && strlen($value) > (int)$param) {
                    $this->addError($field, Lang::t('validation.max_length', ['max' => $param]));
                }

                if ($ruleName === 'match' && $value !== ($this->data[$param] ?? '')) {
                    $this->addError($field, Lang::t('validation.match', ['other' => $param]));
                }

                if ($ruleName === 'unique') {
                    [$table, $col, $exceptId] = array_pad(explode(',', $param), 3, null);
                    $db = new Database();
                    $query = "SELECT id FROM $table WHERE $col = :value";
                    $params = ['value' => $value];

                    if ($exceptId) {
                        $query .= " AND id != :exceptId";
                        $params['exceptId'] = $exceptId;
                    }

                    $exists = $db->fetch($query, $params);
                    if ($exists) {
                        $this->addError($field, Lang::t('validation.existing_value'));
                    }
                }

                if ($ruleName === 'regex' && !preg_match($param, $value)) {
                    $this->addError($field, Lang::t('validation.invalid_format'));
                }
            }
        }

        // Mostra tutti gli errori via Flash
        if (!empty($this->errors)) {
            foreach ($this->errors as $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    Flash::error($error);
                }
            }
        }

        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function isValid(): bool
    {
        $this->validate();
        return empty($this->errors);
    }

    protected function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }
}
