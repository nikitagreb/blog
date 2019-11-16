<?php

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Tag;

class UpdateRequest extends FormRequest
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
        /** @var Tag $tag */
        $tag = $this->tag;

        return [
            'name' => "required|unique:tags,name,$tag->id|max:255",
            'status' => [
                'required',
                Rule::in(array_keys(Tag::statusList()))
            ]
        ];
    }
}
