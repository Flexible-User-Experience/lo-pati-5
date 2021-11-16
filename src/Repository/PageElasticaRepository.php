<?php

namespace App\Repository;

use Elastica\Query\BoolQuery;
use Elastica\Query\MultiMatch;
use Elastica\Query\Term;
use FOS\ElasticaBundle\Repository;

final class PageElasticaRepository extends Repository
{
    public function getFulltextSearchByQueryFilteredByActive(string $query): array
    {
        $multiMatchQuery = new MultiMatch();
        $multiMatchQuery
            ->setQuery($query)
            ->setFuzziness(MultiMatch::FUZZINESS_AUTO)
        ;
        $boolQuery = new BoolQuery();
        $boolQuery->addMust($multiMatchQuery);
        $boolQuery->addFilter(new Term([
            'active' => true,
        ]));

        return $this->find($boolQuery);
    }
}
