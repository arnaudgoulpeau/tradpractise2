<?php

namespace App\Service;

use Symfony\Component\DomCrawler\Crawler;

/**
 * get infos from thesession.org service
 */
class TheSessionInfoService
{
    /**
     * update Tune with infos from thesession.org
     * @param \App\Entity\Tune $tune
     * @return \App\Entity\Tune
     */
    public function updateTuneWithTheSessionInfos(\App\Entity\Tune $tune)
    {
        $link = $tune->getLinkTheSession();

        $crawler = new Crawler();
        $crawler->add(file_get_contents($link));

        $notes = strip_tags($crawler->filter('#settings .setting .notes')->html());

        $tune->setAbc($tune->getAbc().$notes);

        $re = '/K: (.*)/';
        $matches = array();
        preg_match_all($re, $notes, $matches, PREG_SET_ORDER, 0);

        if (isset($matches[0]) && isset($matches[0][1])) {
            $tune->setKey($matches[0][1]);
        }

        return $tune;
    }
}
