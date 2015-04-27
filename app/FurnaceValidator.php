<?php
namespace Furnace;

use Illuminate\Validation\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FurnaceValidator extends Validator
{
    /**
     * @param string       $attribute
     * @param UploadedFile $value
     * @param array        $parameters
     *
     * @return bool
     */
    public function validateExtension($attribute, UploadedFile $value, $parameters)
    {
        if (!$this->isAValidFileInstance($value)) {
            return false;
        }

        return $value->getClientOriginalExtension() === $parameters[0];
    }
}
