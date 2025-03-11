<?php

namespace Jetimob\ActiveCampaign\Models;

class ContactTag
{
    /**
     * Contact to tag association ID.  Used for removing a tag from a contact.
     *
     * @var int
     */
    public int $id;
    /**
     * Contact ID
     *
     * @var int
     */
    public int $contact;
    /**
     * Tag ID
     *
     * @var int
     */
    public int $tag;
    public string $cdate;
    public string $created_timestamp;
    public string $updated_timestamp;
    public ?string $created_by;
    public ?string $updated_by;
    public array $links;
}
