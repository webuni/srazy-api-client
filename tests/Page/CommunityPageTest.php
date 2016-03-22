<?php

namespace Webuni\Srazy\Tests\Page;

use Webuni\Srazy\Page\CommunityPage;

class CommunityPageTest extends AbstractPageTest
{
    public function testGetUsers()
    {
        $page = $this->createPage(CommunityPage::class, file_get_contents(__DIR__.'/fixtures/symfony-brno-community.html'));
        $users = $page->getUsers();

        $this->assertCount(16, $users);
        $this->assertEquals('Martin Mayer', $users[0]->getName());
        $this->assertEquals('http://srazy.info/data/avatars/449-1936214_1201818651464_7028274_n.jpg', $users[0]->getAvatar());
        $this->assertEquals('Petr Jaša', $users[10]->getName());
        $this->assertEquals('http://srazy.info/data/avatars/tw-181711529.png', $users[10]->getAvatar());
    }
}
