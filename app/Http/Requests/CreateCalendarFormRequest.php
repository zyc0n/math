<?php
namespace App\Http\Requests;
use App\Http\Requests\Request;

class CreateCalendarFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules=[];
        foreach($this->request->get('days') as $key => $val)
        {
            $rules['days.'.$key.'.hh']    = 'numeric|max:23';
            $rules['days.'.$key.'.mm']    = 'numeric|max:59';
            $rules['days.'.$key.'.day']   = 'numeric|max:6';
        }
        return $rules;
    }


    public function messages()
    {
        $messages = [];
        foreach($this->request->get('days') as $key => $val)
        {
            $messages['days.'.$key.'.day.max']     = 'Giorno non correto';
            $messages['days.'.$key.'.day.numeric'] = 'Giorno non correto';
            $messages['days.'.$key.'.hh.max']      = 'Ore :max';
            $messages['days.'.$key.'.hh.numeric']  = 'Ore :integer.';
            $messages['days.'.$key.'.mm.max']      = 'Minuti :max.';
            $messages['days.'.$key.'.mm.numeric']  = 'Minuti :integer.';
        }
        return $messages;
    }


}
