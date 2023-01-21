<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PasswordPolicy implements Rule
{
    protected $password;
    protected $error;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->password = config('setting.password');
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (!$this->password) {
            return true;
        } else if ($this->password['minlength'] > 0 && strlen($value) < $this->password['minlength']) {
            $this->error = 'minlength';
            return false;
        } elseif ($this->password['include-numeric'] && !preg_match("/[0-9]/", $value)) {
            $this->error = 'include-numeric';
            return false;
        } elseif ($this->password['include-symbol'] && !preg_match("/[".preg_quote("!#$%()*+-./:;=?@[]^_`{|}","/")."]+/", $value)) {
            $this->error = 'include-symbol';
            return false;
        } elseif ($this->password['minlength'] > 0 && $this->password['frequently-phrases']) {
            if (!isset($this->password['frequently-phrases'][$this->password['minlength']])) {
                return true;
            }
            $phrases = $this->password['frequently-phrases'][$this->password['minlength']];
            if (in_array($value, $phrases)) {
                $this->error = 'frequently-phrases';
                return false;
            }
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        ///'password-policy' => [
        //   'minlength'       => ':attributeは:min文字以上にしてください。',
        return trans("validation.password-policy.$this->error", ['min' => $this->password['minlength']]);
    }
}
