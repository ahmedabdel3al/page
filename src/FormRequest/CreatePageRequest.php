<?php


namespace Code95\Page\FormRequest;

use Code95\Page\Page;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePageRequest extends FormRequest
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
        return [
            'translation' => 'required|in:ar,en',
            'title' => 'required|max:120',
            'slug' => 'required|unique:pages',
            'body' => 'nullable',
            'type' => ['required', Rule::in(array_keys(Page::TYPES))],
        ];
    }
}
