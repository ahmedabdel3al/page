<?php


namespace Code95\Page\Services;


use Code95\Page\Page;
use Illuminate\Http\Request;

class PageServices
{


    public function create(Request $request)
    {

        $page = new Page();
        $page->title = $request->title;
        $page->body = $request->body;
        $page->type = Page::TYPES[$request->type];
        $page->save();

        return $page;
    }

    public function update(Request $request, Page $page)
    {

        $page->update([
            'title' => $request->title,
            'body' => $request->body,
            'type' => $request->type
        ]);

        return $page;
    }


    public function fields()
    {
        return [
            [
                'field' => 'title',
                'type' => 'text',
                'label' => 'Title'
            ],
            [
                'field' => 'body',
                'type' => 'html',
                'label' => 'Body'
            ],
        ];
    }

    public function mapForShow($model)
    {
        return array_map(function ($field) use ($model) {
            return [
                'type' => $field['type'],
                'label' => $field['label'],
                'value' => $model->{$field['field']}
            ];
        }, $this->fields());
    }


}
