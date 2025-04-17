<?php

namespace App\Prototypes;

use App\Models\Campaign;

class CampaignPrototype
{
    public static function clone(Campaign $original)
    {
    
        $clone = $original->replicate([
            'CampName',
            'Description',
            'Amount',
            'Address',
            'Image',
            'Don_Type_Id',
            'Admin_Id',
        ]);

        return $clone;
    }
}
