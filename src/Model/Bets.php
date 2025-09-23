<?php

namespace RestReferenceArchitecture\Model;

use ByJG\MicroOrm\Attributes\FieldAttribute;
use ByJG\MicroOrm\Attributes\FieldUuidAttribute;
use ByJG\MicroOrm\Attributes\TableAttribute;
use ByJG\MicroOrm\Attributes\TableMySqlUuidPKAttribute;
use ByJG\MicroOrm\Literal\HexUuidLiteral;
use OpenApi\Attributes as OA;

/**
 * Class Bets
 * @package RestReferenceArchitecture\Model
 */
#[OA\Schema(required: ["id", "userId", "betOddsId", "stake", "potentialReturn"], type: "object", xml: new OA\Xml(name: "Bets"))]
#[TableAttribute("bets")]
class Bets
{

    /**
     * @var int|null
     */
    #[OA\Property(type: "integer", format: "int32")]
    #[FieldAttribute(primaryKey: true, fieldName: "id")]
    protected int|null $id = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "string")]
    #[FieldUuidAttribute(fieldName: "user_id")]
    protected string|HexUuidLiteral|null $userId = null;

    /**
     * @var int|null
     */
    #[OA\Property(type: "integer", format: "int32")]
    #[FieldAttribute(fieldName: "bet_odds_id")]
    protected int|null $betOddsId = null;

    /**
     * @var float|null
     */
    #[OA\Property(type: "number", format: "double")]
    #[FieldAttribute(fieldName: "stake")]
    protected float|null $stake = null;

    /**
     * @var float|null
     */
    #[OA\Property(type: "number", format: "double")]
    #[FieldAttribute(fieldName: "potential_return")]
    protected float|null $potentialReturn = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "string", nullable: true)]
    #[FieldAttribute(fieldName: "status")]
    protected string|null $status = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "date-time", nullable: true)]
    #[FieldAttribute(fieldName: "placed_at")]
    protected string|null $placedAt = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "date-time", nullable: true)]
    #[FieldAttribute(fieldName: "settled_at")]
    protected string|null $settledAt = null;



    /**
     * @return int|null
     */
    public function getId(): int|null
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return $this
     */
    public function setId(int|null $id): static
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|HexUuidLiteral|null
     */
    public function getUserId(): string|HexUuidLiteral|null
    {
        return $this->userId;
    }

    /**
     * @param string|HexUuidLiteral|null $userId
     * @return $this
     */
    public function setUserId(string|HexUuidLiteral|null $userId): static
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getBetOddsId(): int|null
    {
        return $this->betOddsId;
    }

    /**
     * @param int|null $betOddsId
     * @return $this
     */
    public function setBetOddsId(int|null $betOddsId): static
    {
        $this->betOddsId = $betOddsId;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getStake(): float|null
    {
        return $this->stake;
    }

    /**
     * @param float|null $stake
     * @return $this
     */
    public function setStake(float|null $stake): static
    {
        $this->stake = $stake;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getPotentialReturn(): float|null
    {
        return $this->potentialReturn;
    }

    /**
     * @param float|null $potentialReturn
     * @return $this
     */
    public function setPotentialReturn(float|null $potentialReturn): static
    {
        $this->potentialReturn = $potentialReturn;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getStatus(): string|null
    {
        return $this->status;
    }

    /**
     * @param string|null $status
     * @return $this
     */
    public function setStatus(string|null $status): static
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlacedAt(): string|null
    {
        return $this->placedAt;
    }

    /**
     * @param string|null $placedAt
     * @return $this
     */
    public function setPlacedAt(string|null $placedAt): static
    {
        $this->placedAt = $placedAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSettledAt(): string|null
    {
        return $this->settledAt;
    }

    /**
     * @param string|null $settledAt
     * @return $this
     */
    public function setSettledAt(string|null $settledAt): static
    {
        $this->settledAt = $settledAt;
        return $this;
    }


}
