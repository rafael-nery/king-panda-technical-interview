<?php

namespace RestReferenceArchitecture\Repository;

use RestReferenceArchitecture\Psr11;
use ByJG\MicroOrm\Exception\OrmModelInvalidException;
use ReflectionException;
use ByJG\AnyDataset\Db\DbDriverInterface;
use ByJG\MicroOrm\Query;
use ByJG\MicroOrm\Repository;
use RestReferenceArchitecture\Model\Bets;

class BetsRepository extends BaseRepository
{
    /**
     * BetsRepository constructor.
     *
     * @param DbDriverInterface $dbDriver
     * @throws OrmModelInvalidException
     * @throws ReflectionException
     */
    public function __construct(DbDriverInterface $dbDriver)
    {
        $this->repository = new Repository($dbDriver, Bets::class);
    }


    /**
     * @param mixed $userId
     * @return null|Bets[]
     */
    public function getByUserId($userId)
    {
        $query = Query::getInstance()
            ->table('bets')
            ->where('bets.user_id = :value', ['value' => $userId])
            ->orderBy(['bets.placed_at DESC']);
        $result = $this->repository->getByQuery($query);
        return $result;
    }

    /**
     * @param mixed $betOddsId
     * @return null|Bets[]
     */
    public function getByBetOddsId($betOddsId)
    {
        $query = Query::getInstance()
            ->table('bets')
            ->where('bets.bet_odds_id = :value', ['value' => $betOddsId])
            ->orderBy(['bets.placed_at DESC']);
        $result = $this->repository->getByQuery($query);
        return $result;
    }

    /**
     * @param mixed $status
     * @return null|Bets[]
     */
    public function getByStatus($status)
    {
        $query = Query::getInstance()
            ->table('bets')
            ->where('bets.status = :value', ['value' => $status]);
        $result = $this->repository->getByQuery($query);
        return $result;
    }

    /**
     * @param mixed $placedAt
     * @return null|Bets[]
     */
    public function getByPlacedAt($placedAt)
    {
        $query = Query::getInstance()
            ->table('bets')
            ->where('bets.placed_at = :value', ['value' => $placedAt]);
        $result = $this->repository->getByQuery($query);
        return $result;
    }

}
