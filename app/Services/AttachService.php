<?php

namespace App\Services;

class AttachService
{
    public function attachRelatedModel ($model, $relatedModelIds) {
        if (isset($relatedModelIds)) {
            $model->rooms()->attach($relatedModelIds);
        }
    }
}
