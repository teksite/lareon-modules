<?php

namespace Lareon\Modules\Gadget\App\Http\Controllers\Web\Admin\Gadgets;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Gadget\App\Http\Requests\Admin\NewGadgetRequest;
use Lareon\Modules\Gadget\App\Http\Requests\Admin\UpdateGadgetRequest;
use Lareon\Modules\Gadget\App\Logic\GadgetLogic;
use Lareon\Modules\Gadget\App\Models\Gadget;
use Lareon\Modules\Gadget\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Teksite\Lareon\Facade\WebResponse;

class GadgetsController extends Controller implements HasMiddleware
{
    public function __construct(public GadgetLogic $logic)
    {
    }


    public static function middleware()
    {
        return [
            new Middleware('can:admin.gadget.read'),
            new Middleware('can:admin.gadget.create', only: ['create', 'store']),
            new Middleware('can:admin.gadget.edit', only: ['edit', 'update']),
            new Middleware('can:admin.gadget.delete', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gadgets = $this->logic->get()->result;
        $count = $this->logic->trashCount()->result;

        return view('gadget::admin.pages.gadgets.index', compact('gadgets' ,'count'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gadget::admin.pages.gadgets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewGadgetRequest $request)
    {
        $res = $this->logic->register($request->validated());
        return WebResponse::byResult($res ,route('admin.appearance.gadgets.edit', $res->result))->go();
    }

    /**
     * Display the specified resource.
     */
    public function show(Gadget $gadget)
    {
         abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gadget $gadget)
    {
        return view('gadget::admin.pages.gadgets.edit', compact('gadget'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGadgetRequest $request, Gadget $gadget)
    {
        $res = $this->logic->change($request->validated(), $gadget);
        return WebResponse::byResult($res, route('admin.appearance.gadgets.edit', $gadget))->go();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gadget $gadget)
    {
        $res = $this->logic->delete($gadget);
        return WebResponse::byResult($res, route('admin.appearance.gadgets.index'))->go();
    }
}
