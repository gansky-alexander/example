<?php

namespace App\Model;

use App\Dto\ApiError;
use Symfony\Component\Validator\ConstraintViolationList;

trait ErrorTrait
{

   public function prepareError(ConstraintViolationList $errors)
   {
       $apiError = new ApiError();

       foreach($errors as $error) {
           $apiError->addError(
               $error->getPropertyPath(),
               $error->getMessage()
           );
       }

       return $apiError;
   }
}