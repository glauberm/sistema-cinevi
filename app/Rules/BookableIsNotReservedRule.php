<?php

namespace App\Rules;

use App\Services\BookableService;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class BookableIsNotReservedRule implements DataAwareRule, ValidationRule
{
    /**
     * @var array<string,mixed>
     */
    protected $data = [];

    public function __construct(private readonly BookableService $bookableService)
    {
    }

    /**
     * @param  array<string,mixed>  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        /** @var string $withdrawalDate */
        $withdrawalDate = $this->data['withdrawal_date'];

        /** @var string $devolutionDate */
        $devolutionDate = $this->data['devolution_date'];

        if ($this->bookableService->hasConflictingBookingDate(
            intval($value),
            $withdrawalDate,
            $devolutionDate
        )) {
            $fail('As reservas estão fechadas para alunos.');
        }
    }
}
