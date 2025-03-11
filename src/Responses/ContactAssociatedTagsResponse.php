<?php

namespace Jetimob\ActiveCampaign\Responses;

class ContactAssociatedTagsResponse
{
    /**
     * @var \Jetimob\ActiveCampaign\Models\ContactTag[]
     */
    public array $contactTags = [];

    /**
     * Collect all tag IDs in the response
     *
     * @return array<int, int>  Key of association ID, value of tag ID
     */
    public function getTagIds(): array
    {
        $result = [];

        foreach ($this->contactTags as $contactTag) {
            $result[$contactTag->id] = $contactTag->tag;
        }

        return $result;
    }
}