<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Foundation\Http\FormRequest;
    use Illuminate\Http\Exceptions\HttpResponseException;
    use Illuminate\Http\Response;
    use Illuminate\Validation\ValidationException;

class AttendaceRequest extends FormRequest
{
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules():array
    {
        return [
            'date_at' => 'required|date',
            'employee_id' => 'required|exists:employees,id',
            'time_attendance' => 'required',
            
        ];
    }
   
    
    // public function messages(){
    //     return[
    //        'date_at'=>'data tidak boleh kosong',
    //        'employee_id'=>'data tidak boleh kosong',
    //        'time_attendance'=>'data tidak valid'
    //     ];
    // }
      /**
         * Handle a failed validation attempt.
         *
         * @param Validator $validator
         * @return void
         *
         * @throws ValidationException
         */
        protected function failedValidation(Validator $validator)
        {
            $error = collect($validator->errors())->collapse()->toArray();
            $errors = implode(' | ', $error);
            throw new HttpResponseException(response()->json(
                ['response' => ['status' => false, 'message' => $errors]],
                Response::HTTP_UNPROCESSABLE_ENTITY));
        }
}
