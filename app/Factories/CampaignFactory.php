<?php
namespace App\Factories;

use App\Models\Campaign;

class CampaignFactory
{
    public static function createCampaign($type, $data)
    {
        $validTypes = ['money', 'food', 'clothes', 'books', 'blood'];
        if (!in_array($type, $validTypes)) {
            throw new \Exception('Invalid campaign type');
        }
        return self::createGenericCampaign($data);
    }
    
    private static function createGenericCampaign($data)
    {
        return Campaign::create([
            'CampName' => $data['CampName'],
            'Description' => $data['Description'],
            'StartDate' => $data['StartDate'],
            'EndDate' => $data['EndDate'],
            'Image' => $data['Image'] ?? null,
            'Amount' => $data['Amount'],
            'Address' => $data['Address'],
            'Admin_Id' => $data['Admin_Id'],
            'Don_Type_Id' => $data['Don_Type_Id']
        ]);
    }
    
}
