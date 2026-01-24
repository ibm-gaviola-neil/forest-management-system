<?php

namespace App\Http\Services;

use App\Models\Tree;

class TreesService {
    public function getTreeData($role = 'applicant', $request)
    {
        $data = [];

        $query = Tree::query();

        $query->when(filled($request->search), function ($q) use ($request, $role) {
            $keyword = $request->search;
            $q->where(function($sub) use ($keyword, $role) {
                $sub->where('treeId', 'LIKE', "%{$keyword}%")
                    ->orWhere('treeType', 'LIKE', "%{$keyword}%")
                    ->orWhere('location', 'LIKE', "%{$keyword}%");

                // Add user name search only for general_admin role
                if ($role === 'general_admin') {
                    $sub->orWhereHas('user', function($userQuery) use ($keyword) {
                        $userQuery->where('last_name', 'LIKE', "%{$keyword}%")
                                ->orWhere('first_name', 'LIKE', "%{$keyword}%");
                    });
                }
            });
        });

        $query->when(filled($request->status), function ($q) use ($request) {
            $status = $request->status;
            $q->where('status', $status);
        });

        if ($role === 'applicant') {
            $query->where('user_id', auth()->user()->id);
        }  

        if ($role === 'general_admin') {
            $query->with('user');
        }  

        $data = $query->orderBy('created_at', 'DESC')
            ->paginate(20);

        return $data;
    }

    public function getTreeCoordinates($role = 'applicant', $request)
    {
        $data = [];

        $query = Tree::query();

        $query->when(filled($request->search), function ($q) use ($request, $role) {
            $keyword = $request->search;
            $q->where(function($sub) use ($keyword, $role) {
                $sub->where('treeId', 'LIKE', "%{$keyword}%")
                    ->orWhere('treeType', 'LIKE', "%{$keyword}%")
                    ->orWhere('location', 'LIKE', "%{$keyword}%");

                // Add user name search only for general_admin role
                if ($role === 'general_admin') {
                    $sub->orWhereHas('user', function($userQuery) use ($keyword) {
                        $userQuery->where('last_name', 'LIKE', "%{$keyword}%")
                                ->orWhere('first_name', 'LIKE', "%{$keyword}%");
                    });
                }
            });
        });

        $data = $query->whereIn('status',  [1,4])->get(['lattitude', 'longitude', 'status']);

        return $data;
    }
}