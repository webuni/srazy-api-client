<?php

namespace Webuni\Srazy\Tests\Page;

use Webuni\Srazy\Page\SearchPage;

class SearchPageTest extends AbstractPageTest
{
    public function testGetSeries()
    {
        $page = $this->createPage(SearchPage::class, file_get_contents(__DIR__.'/fixtures/web-search.html'));
        $series = $page->getSeries();

        $this->assertCount(22, $series);
        $this->assertEquals(['WebCamp', 'http://srazy.info/webcamp'], [$series[0]->getName(), $series[0]->getUri()]);
        $this->assertEquals(['Konference Dobrý web', 'http://srazy.info/konference-dobry-web'], [$series[1]->getName(), $series[1]->getUri()]);
        $this->assertEquals(['Vendavo Tech Talk - Face of Modern Web-App (česky)', 'http://srazy.info/vendavo-tech-talk-face-of-modern-web-app'], [$series[21]->getName(), $series[21]->getUri()]);
    }

    public function testGetUsers()
    {
        $page = $this->createPage(SearchPage::class, file_get_contents(__DIR__.'/fixtures/web-search.html'));
        $users = $page->getUsers();

        $this->assertCount(15, $users);
        $this->assertEquals(['WebExpo', 'http://srazy.info/lide/webexpo'], [$users[0]->getName(), $users[0]->getUri()]);
        $this->assertEquals(['Weblogy.cz', 'http://srazy.info/lide/weblogycz'], [$users[1]->getName(), $users[1]->getUri()]);
        $this->assertEquals(['Webdesign GRAFIQUE', 'http://srazy.info/lide/webdesign-grafique'], [$users[14]->getName(), $users[14]->getUri()]);
    }
}
