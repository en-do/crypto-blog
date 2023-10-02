<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Parsing;
use Illuminate\Http\Request;

use App\Services\Traits\LighthouseAPI;

class ParsingController extends Controller
{
    use LighthouseAPI;

    public function list() {
        $parser = Parsing::paginate(10);

        return view('dashboard.parsing.list', compact('parser'));
    }

    public function add() {
        $domains = Domain::get();

        return view('dashboard.parsing.add', compact('domains'));
    }

    public function edit($id) {
        $parsing = Parsing::findOrFail($id);
        $domains = Domain::get();

        return view('dashboard.parsing.edit', compact('parsing', 'domains'));
    }

    public function create(Request $request) {
        $request->validate([
            'domain' => ['required', 'integer', 'gte:1'],
            'query' => ['required', 'min:3', 'max:128'],
            'from_at' => ['nullable'],
            'to_at' => ['nullable'],
            'language' => ['nullable', 'string', 'size:2'],
            'country' => ['nullable', 'string', 'size:2'],
            'sort' => ['required', 'in:relevancy,popularity,publishedAt,random'],
            'limit' => ['required', 'integer', 'min:1', 'max:100'],
            'active' => ['required']
        ]);

        $parsing = new Parsing;

        $parsing->domain_id = $request->domain;
        $parsing->query = $request->get('query');
        $parsing->from_at = $request->from_at;
        $parsing->to_at = $request->to_at;
        $parsing->language = $request->language;
        $parsing->country = $request->country;
        $parsing->sort = $request->sort;
        $parsing->limit = $request->limit;
        $parsing->active = $request->active;

        if($parsing->saveOrFail()) {
            return redirect()->route('dashboard.parsing')->with('success', "Parsing $parsing->id created");
        }
    }

    public function update(Request $request, $id) {
        $request->validate([
            'domain' => ['required', 'integer'],
            'query' => ['required', 'min:3', 'max:128'],
            'from_at' => ['nullable'],
            'to_at' => ['nullable'],
            'language' => ['nullable', 'string', 'size:2'],
            'country' => ['nullable', 'string', 'size:2'],
            'sort' => ['required', 'in:relevancy,popularity,publishedAt,random'],
            'limit' => ['required', 'integer', 'min:1', 'max:100'],
            'active' => ['required']
        ]);

        $parsing = Parsing::findOrFail($id);

        $parsing->domain_id = $request->domain;
        $parsing->query = $request->get('query');
        $parsing->from_at = $request->from_at;
        $parsing->to_at = $request->to_at;
        $parsing->language = $request->language;
        $parsing->country = $request->country;
        $parsing->sort = $request->sort;
        $parsing->limit = $request->limit;
        $parsing->active = $request->active;

        if($parsing->saveOrFail()) {
            return redirect()->route('dashboard.parsing')->with('success', "Parsing $parsing->id updated");
        }
    }

    public function delete($id) {
        $parsing = Parsing::findOrFail($id);

        if($parsing->delete()) {
            return redirect()->route('dashboard.parsing')->with('success', "Parsing $parsing->id deleted");
        }
    }
}
