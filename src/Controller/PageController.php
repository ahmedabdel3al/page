<?php


namespace Code95\Page\Controller;


use Code95\Page\FormRequest\CreatePageRequest;
use Code95\Page\FormRequest\UpdatePageRequest;
use Code95\Page\Page;
use Code95\Page\Resources\SeoResource;
use Code95\Page\Services\PageServices;
use Code95\Page\Services\SeoService;
use Illuminate\Http\Request;

class PageController
{
    public $admin_page_service;
    public $seo_service;

    public function __construct(
        PageServices $admin_page_service,
        SeoService $seo_service

    )
    {
        $this->admin_page_service = $admin_page_service;
        $this->seo_service = $seo_service;
    }

    public function index()
    {
        return view('admin.page.index');
    }

    public function show(Request $request, Page $page)
    {
        return view('admin.page.show', [
            'items' => $this->admin_page_service->mapForShow($page),
            'options' =>
                admin_show_options(
                    $page,
                    [
                        'delete_url' => '',
                    ]
                )
        ]);
    }

    public function getJson(Request $request)
    {
//        return AdminPageIndexResource::collection(
//            $this->admin_page_service->fetchRecords()->paginate()
//        );
    }

    public function create(Request $request)
    {
        return view('admin.page.create', [
            'options' => admin_create_form_options(class_basename(Page::class))
        ]);
    }

    public function store(CreatePageRequest $request)
    {
        $page = $this->admin_page_service->create($request);
        $this->seo_service->createOrUpdate($page, $request->get('seo'));

        return response()->json([
            'data' => $page
        ], 200);
    }

    public function edit(Request $request, Page $page)
    {
        $page = new AdminPageResource($page);
        return view('admin.page.edit', [
            'page' => $page,
            'options' => admin_update_form_options($page, class_basename(Page::class), [
                'seo' => new SeoResource($page->seo)
            ]),
        ]);
    }

    public function update(UpdatePageRequest $request, Page $page)
    {
        $page = $this->admin_page_service->update($request, $page);
        $this->seo_service->createOrUpdate($page, $request->get('seo'));

        return response()->json([
            'data' => $page
        ], 200);
    }

}
