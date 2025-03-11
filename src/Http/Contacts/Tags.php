<?php

namespace Jetimob\ActiveCampaign\Http\Contacts;

use GuzzleHttp\RequestOptions;
use Jetimob\ActiveCampaign\Http\Resource;
use Jetimob\ActiveCampaign\Responses\ContactAssociatedTagsResponse;

/**
 * Manage tags associated with contacts
 *
 * @package Jetimob\ActiveCampaign\Contacts
 * @see     https://developers.activecampaign.com/reference#contact-tags
 */
class Tags extends Resource
{
    protected const BASE_URL = '/api/3/contactTags';

    /**
     * Associate tags with contacts.
     *
     * @see https://developers.activecampaign.com/reference#create-contact-tag
     */
    public function add(int $contactId, int|array $tagId): array
    {
        $originalIsArray = is_array($tagId);
        $tagId           = (array)$tagId;

        $results = [];
        foreach ($tagId as $tag) {
            $results[] = $this->httpPost(static::BASE_URL, [
                RequestOptions::JSON => [
                    'contactTag' => [
                        'contact' => $contactId,
                        'tag'     => $tag,
                    ]
                ]
            ]);
        }

        // If they only passed a single ID, they expect a single response.
        if (!$originalIsArray) {
            return $results[0];
        }

        // Return an array of responses
        return $results;
    }


    /**
     * Delete contactTag.  Note this takes an association ID, not a contact id + tag id.  This can be acquired from the add
     * tag result, or from listAssociatedTags()
     *
     * @see https://developers.activecampaign.com/reference#delete-contact-tag
     */
    public function delete(int $contactTagId): bool
    {
        return count($this->httpDelete(static::BASE_URL . "/{$contactTagId}")) === 0;
    }

    public function listAssociatedTags(int $contactId): ContactAssociatedTagsResponse
    {
        $res = $this->httpGet("/api/3/contacts/$contactId/contactTags");

        $mapper = new \JsonMapper();
        // Let mapper take an array as input
        $mapper->bEnforceMapType = false;

        return $mapper->map($res, ContactAssociatedTagsResponse::class);
    }
}
