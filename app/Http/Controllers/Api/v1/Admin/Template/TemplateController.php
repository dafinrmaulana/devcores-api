<?php

namespace App\Http\Controllers\Api\v1\Admin\Template;

use App\Http\Controllers\Controller;
use App\Http\Requests\Template\TemplateStoreRequest;
use App\Http\Requests\Template\TemplateUpdateRequest;
use App\Http\Resources\TemplateResource;
use App\Models\Template;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return (new TemplateResource(Template::paginate(20)))
            ->setSuccess(true)
            ->setMessage('Templates retrieved successfully')
            ->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TemplateStoreRequest $request)
    {
        $template = Template::create($request->data());
        return (new TemplateResource($template))
            ->setSuccess(true)
            ->setMessage("Template {$template->name} created successfully")
            ->setStatusCode(201)
            ->response();
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        return (new TemplateResource($template))
            ->setSuccess(true)
            ->setMessage('Template retrieved successfully')
            ->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TemplateUpdateRequest $request, Template $template)
    {
        $template->update($request->data());
        return (new TemplateResource($template))
            ->setSuccess(true)
            ->setMessage("Template {$template->name} updated successfully")
            ->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        try {
            if ($template->thumbnail) {
                Storage::delete($template->thumbnail);
            }
            $template->delete();
            return (new TemplateResource($template))
                ->setSuccess(true)
                ->setMessage("Template {$template->name} deleted successfully")
                ->response();
        } catch (\Illuminate\Database\QueryException $e) {

            // Foreign key constraint violation
            if ($e->getCode() === "23000") {
                return (new TemplateResource($template))
                    ->setSuccess(false)
                    ->setMessage("Cannot delete template '{$template->name}' because it is being used in other records. Please update or delete related data first.")
                    ->setStatusCode(400)
                    ->response();
            }

            return (new TemplateResource($template))
                ->setSuccess(false)
                ->setMessage($e->getMessage())
                ->setStatusCode(500)
                ->response();
        }
    }
}
