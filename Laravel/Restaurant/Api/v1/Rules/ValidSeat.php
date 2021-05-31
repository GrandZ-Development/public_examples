<?php

namespace App\Modules\Restaurant\Api\v1\Rules;

use App\Modules\Restaurant\Models\Table;
use Illuminate\Contracts\Validation\Rule;

class ValidSeat implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $tableId;
    private $seatsCount;
    public function __construct($tableId)
    {
        $this->tableId = $tableId;
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
        $table = Table::find($this->tableId);
        $this->seatsCount = $table->seats->count();
        return $value <= $this->seatsCount ? true : false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "This table can not have more that $this->seatsCount seats.";
    }
}
