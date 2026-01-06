<?php

namespace App\Http\Services;

use App\Models\Tree;

class TreesService {
    public function getTreeData($role = 'applicant', $request)
    {
        $data = [];

        $query = Tree::query();

        $query->when(filled($request->search), function ($q) use ($request) {
            $keyword = $request->search;
            $q->where(function($sub) use ($keyword) {
                $sub->where('treeId', 'LIKE', "%{$keyword}%")
                    ->orWhere('treeType', 'LIKE', "%{$keyword}%")
                    ->orWhere('location', 'LIKE', "%{$keyword}%");
            });
        });

        $query->when(filled($request->status), function ($q) use ($request) {
            $status = $request->status;
            $q->where('status', $status);
        });

        if ($role === 'applicant') {
            $data = $query->where('user_id', auth()->user()->id)->orderBy('treeId', 'DESC')->paginate(20);
        } 

        return $data;
    }
}