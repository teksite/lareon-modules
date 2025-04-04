<?php

namespace Lareon\Modules\Seo\App\Http\Controllers\Web\Admin\Seo;

use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Lareon\Modules\Seo\App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Lareon\Modules\Seo\App\Logic\RobotLogic;
use Teksite\Lareon\Facade\WebResponse;

class RobotController extends Controller implements HasMiddleware
{
    public function __construct(public RobotLogic $logic)
    {
    }

    public static function middleware()
    {
        return [
            new Middleware('can:admin.seo.robot.edit'),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $content=$this->logic->getContent()->result;
        return view('seo::admin.pages.robot.edit', compact('content'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated=$request->validate([
            'content' => 'required|string',
        ]);
        $res = $this->logic->changeContent($validated);
        return WebResponse::byResult($res)->go();
    }
}
