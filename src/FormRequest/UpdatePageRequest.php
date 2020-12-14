<?php


namespace Code95\Page\FormRequest;

class UpdatePageRequest extends CreatePageRequest
{
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->page->is_permanent && $this->page->slug !== $this->slug) {
                $validator->errors()->add('slug', 'you can not change slug of permanent page');
            }
        });
    }
}
