<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSensorRequest extends FormRequest
{

    /*public function authorize()
    {
        return Auth::check();
    }*/

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uuid' => array('required', 'regex:/[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}/u'),
            'pin' => 'required|max:9999|min:0|numeric',
            'name' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'uuid' => __('unique sensor identification (UUID)'),
            'pin' => __('sensor pin'),
            'name' => __('name')
        ];
    }
}
