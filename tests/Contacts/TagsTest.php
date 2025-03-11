<?php

namespace Contacts;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Jetimob\ActiveCampaign\Http\Contacts\Tags;
use PHPUnit\Framework\TestCase;

class TagsTest extends TestCase
{
    public function testListAssociatedTags()
    {
        $raw  = file_get_contents(__DIR__ . '/../fixtures/list-associated-tags-success.json');
        $mock = new MockHandler([
            new Response(body: $raw),
        ]);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handlerStack]);
        $libClient    = new \Jetimob\ActiveCampaign\Http\Client($guzzleClient);
        $tags         = new Tags($libClient);
        $res          = $tags->listAssociatedTags(123);

        $this->assertCount(2, $res->contactTags);

        $resultTags = $res->getTagIds();
        $this->assertCount(2, $resultTags);

        // association 2 is tag 4
        $this->assertSame(4, $resultTags[2]);
    }
}
