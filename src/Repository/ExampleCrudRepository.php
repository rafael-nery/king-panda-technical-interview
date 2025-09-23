<?php

namespace RestReferenceArchitecture\Repository;

use RestReferenceArchitecture\Psr11;
use ByJG\MicroOrm\Exception\OrmModelInvalidException;
use ReflectionException;
use ByJG\AnyDataset\Db\DbDriverInterface;
use ByJG\MicroOrm\Query;
use ByJG\MicroOrm\Repository;
use RestReferenceArchitecture\Model\ExampleCrud;

class ExampleCrudRepository extends BaseRepository
{
    /**
     * ExampleCrudRepository constructor.
     *
     * @param DbDriverInterface $dbDriver
     * @throws OrmModelInvalidException
     * @throws ReflectionException
     */
    public function __construct(DbDriverInterface $dbDriver)
    {
        $this->repository = new Repository($dbDriver, ExampleCrud::class);
    }


}
