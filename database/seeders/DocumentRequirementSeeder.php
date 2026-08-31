<?php

namespace Database\Seeders;

use App\Models\DocumentRequirement;
use Illuminate\Database\Seeder;

class DocumentRequirementSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            [
                'name' => 'Assessment Form',
                'description' => 'Original Copy w/ Signature',
                'copy_type' => 'Original Copy',
                'is_required' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Grade Slip',
                'description' => 'Original Copy w/ GWA',
                'copy_type' => 'Original Copy',
                'is_required' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Prospectus',
                'description' => 'Photocopy of the approved/official prospectus',
                'copy_type' => 'Photocopy',
                'is_required' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Certificate of Non-availment',
                'description' => 'Certificate stating non-availment of other scholarship benefits',
                'copy_type' => 'Original Copy',
                'is_required' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($defaults as $doc) {
            DocumentRequirement::updateOrCreate(
                ['name' => $doc['name']],
                $doc
            );
        }
    }
}
