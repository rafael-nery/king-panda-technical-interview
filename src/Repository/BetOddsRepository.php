<?php

namespace RestReferenceArchitecture\Repository;

use RestReferenceArchitecture\Psr11;
use ByJG\MicroOrm\Exception\OrmModelInvalidException;
use ReflectionException;
use ByJG\AnyDataset\Db\DbDriverInterface;
use ByJG\MicroOrm\Query;
use ByJG\MicroOrm\Repository;
use RestReferenceArchitecture\Model\BetOdds;

class BetOddsRepository extends BaseRepository
{
    /**
     * BetOddsRepository constructor.
     *
     * @param DbDriverInterface $dbDriver
     * @throws OrmModelInvalidException
     * @throws ReflectionException
     */
    public function __construct(DbDriverInterface $dbDriver)
    {
        $this->repository = new Repository($dbDriver, BetOdds::class);
    }


    /**
     * @param mixed $eventDate
     * @return null|BetOdds[]
     */
    public function getByEventDate($eventDate)
    {
        $query = Query::getInstance()
            ->table('bet_odds')
            ->where('bet_odds.event_date = :value', ['value' => $eventDate])
            ->orderBy(['bet_odds.event_date ASC', 'bet_odds.id ASC']);
        $result = $this->repository->getByQuery($query);
        return $result;
    }

    /**
     * @param mixed $status
     * @return null|BetOdds[]
     */
    public function getByStatus($status)
    {
        $query = Query::getInstance()
            ->table('bet_odds')
            ->where('bet_odds.status = :value', ['value' => $status])
            ->orderBy(['bet_odds.event_date ASC', 'bet_odds.id ASC']);
        $result = $this->repository->getByQuery($query);
        return $result;
    }

    /**
     * @param mixed $marketType
     * @return null|BetOdds[]
     */
    public function getByMarketType($marketType)
    {
        $query = Query::getInstance()
            ->table('bet_odds')
            ->where('bet_odds.market_type = :value', ['value' => $marketType])
            ->orderBy(['bet_odds.event_date ASC', 'bet_odds.id ASC']);
        $result = $this->repository->getByQuery($query);
        return $result;
    }

}
