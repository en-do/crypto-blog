<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Domain;

class DomainController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function list() {
        if(auth()->user()->cannot('domain-list')) {
            abort(403);
        }

        $domains = Domain::paginate(10);

        return view('dashboard.domains.list', compact('domains'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function add() {
        if(auth()->user()->cannot('domain-add')) {
            abort(403);
        }

        $templates = Storage::disk("template")->directories();

        return view('dashboard.domains.add', compact('templates'));
    }

    /**
     * @param $domain_id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($domain_id) {
        if(auth()->user()->cannot('domain-edit')) {
            abort(403);
        }

        $domain = Domain::findOrFail($domain_id);
        $templates = Storage::disk("template")->directories();

        return view('dashboard.domains.edit', compact('domain', 'templates'));
    }

    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     */
    public function create(Request $request) {
        if(auth()->user()->cannot('domain-create')) {
            abort(403);
        }

        $request->validate([
            'title' => ['required', 'string', 'min:4'],
            'host' => ['required', 'string', 'min:4', 'unique:domains'],
            'template' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft']
        ]);

        $domain = new Domain;
        $domain->template = $request->template;
        $domain->host = $request->host;
        $domain->title = $request->title;
        $domain->status = $request->status;

        if($domain->saveOrFail()) {
            $domain->meta()->create([
                'title' => $request->meta_title,
                'description' => $request->meta_description,
                'no_index' => $request->index ?? 0
            ]);

            return redirect()->route('dashboard.domains')->width('success', 'Domain created');
        }
    }

    /**
     * @param Request $request
     * @param $domain_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $domain_id) {
        if(auth()->user()->cannot('domain-update')) {
            abort(403);
        }

        $request->validate([
            'title' => ['required', 'string', 'min:4'],
            'host' => ['required', 'string', 'min:4', 'unique:domains,host,' . $domain_id],
            'template' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft']
        ]);

        $domain = Domain::findOrFail($domain_id);
        $domain->template = $request->template;
        $domain->host = $request->host;
        $domain->title = $request->title;
        $domain->status = $request->status;

        if($domain->saveOrFail()) {
            $domain->meta()->update([
                'title' => $request->meta_title ?? null,
                'description' => $request->meta_description ?? null,
                'no_index' => $request->index ?? 0
            ]);

            return redirect()->route('dashboard.domains')->with('success', 'Domain created');
        }
    }

    /**
     * @param $domain_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($domain_id) {
        if(auth()->user()->cannot('domain-delete')) {
            abort(403);
        }

        $domain = Domain::findOrFail($domain_id);

        if($domain->delete()) {
            return redirect()->route('dashboard.domains')->with('success', 'Domain deleted');
        }
    }
}
