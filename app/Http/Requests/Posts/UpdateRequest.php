<?php

namespace App\Http\Requests\Posts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Post;

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
        /** @var Post $post */
        $post = $this->post;

        return [
            'h1' => "required|unique:posts,h1,$post->id|max:100",
            'title' => "required|unique:posts,title,$post->id|max:100",
            'description' => 'required|max:200',
            'keywords' => 'required|max:200',
            'text' => 'required',
            'tags' => 'required|array',
            'status' => [
                'required',
                Rule::in(array_keys(Post::statusList()))
            ]
        ];
    }
}
