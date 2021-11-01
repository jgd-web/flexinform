<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyOneOf implements Rule
{
    private array $oneOf = [];
    private ?string $message = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $oneOf, string $message = null)
    {
        $this->oneOf = $oneOf;
        $this->message = $message;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $count = 0;
        foreach ($this->oneOf as $param) {

            if (request()->has($param) === request()->filled($param)) {
                $count++;
            }
        }
        return count($this->oneOf) && ($count === 1);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        $json_encodedList = json_encode($this->oneOf);

        return $this->message ?? "Please insert one of $json_encodedList.";
    }
}
