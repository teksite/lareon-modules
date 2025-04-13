<?php

namespace Lareon\Modules\Questionnaire\App\Http\Controllers\Web\Admin\Inboxes;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Questionnaire\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Questionnaire\App\Http\Requests\Admin\UpdateInboxRequest;
use Lareon\Modules\Questionnaire\App\Logic\InboxLogic;
use Lareon\Modules\Questionnaire\App\Models\Inbox;
use Teksite\Lareon\Facade\WebResponse;

class InboxesController extends Controller implements HasMiddleware
{
    public function __construct(public InboxLogic $logic)
    {
    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:admin.questionnaire.inbox.read'),
            new Middleware('can:admin.questionnaire.inbox.create', only: ['create', 'store']),
            new Middleware('can:admin.questionnaire.inbox.edit', only: ['edit', 'update']),
            new Middleware('can:admin.questionnaire.inbox.delete', only: ['destroy']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if ($formId=request()->form){
            $inboxes = $this->logic->getByForm($formId)->result;
        }else{
            $inboxes = $this->logic->get()->result;
        }
        $count = $this->logic->trashCount()?->result;

        return view('questionnaire::admin.pages.inboxes.index', compact('inboxes' ,'count'));
    }

    /**
     * Show the inbox for creating a new resource.
     */
    public function create()
    {
        abort(404);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);

    }

    /**
     * Display the specified resource.
     */
    public function show(Inbox $inbox)
    {
        abort(404);

    }

    /**
     * Show the inbox for editing the specified resource.
     */
    public function edit(Inbox $inbox)
    {
        $this->logic->markAsRead($inbox);
        return view('questionnaire::admin.pages.inboxes.edit', compact('inbox'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInboxRequest $request, Inbox $inbox)
    {
        $res = $this->logic->change($request->validated(), $inbox);
        return WebResponse::byResult($res, route('admin.questionnaire.inboxes.edit', $inbox))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inbox $inbox)
    {
        $res = $this->logic->delete($inbox);
        return WebResponse::byResult($res, route('admin.questionnaire.inboxes.index'))->go();
    }
}
