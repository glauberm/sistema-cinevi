<?php

namespace App\Rules;

use App\Services\BookableService;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\InvokableRule;

class BookableIsNotReservedRule implements DataAwareRule, InvokableRule
{
    /**
     * All of the data under validation.
     *
     * @var array<string,mixed>
     */
    protected $data = [];

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private readonly BookableService $bookableService)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        /** @var string $withdrawalDate */
        $withdrawalDate = $this->data['withdrawal_date'];

        /** @var string $devolutionDate */
        $devolutionDate = $this->data['devolution_date'];

        if ($this->bookableService->hasConflictingBookingDate(\intval($value), $withdrawalDate, $devolutionDate)) {
            $fail('As reservas estão fechadas para alunos.');
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string,mixed>  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }
}
