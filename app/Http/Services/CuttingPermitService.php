<?php

namespace App\Http\Services;

use App\Models\ChainsawRequest;
use App\Models\Tree;

class CuttingPermitService {
    public function getSelectableData()
    {
        $registeredTrees = Tree::select('id', 'treeId', 'treeType')
            ->where('status', 1)
            ->orderBy('treeId', 'ASC')->get();
        
        return [
            'registeredTrees' => $registeredTrees
        ];
    }
}