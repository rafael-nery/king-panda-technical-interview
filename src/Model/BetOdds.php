<?php

namespace RestReferenceArchitecture\Model;

use ByJG\MicroOrm\Attributes\FieldAttribute;
use ByJG\MicroOrm\Attributes\FieldUuidAttribute;
use ByJG\MicroOrm\Attributes\TableAttribute;
use ByJG\MicroOrm\Attributes\TableMySqlUuidPKAttribute;
use ByJG\MicroOrm\Literal\HexUuidLiteral;
use OpenApi\Attributes as OA;

/**
 * Class BetOdds
 * @package RestReferenceArchitecture\Model
 */
#[OA\Schema(required: ["id", "eventName", "eventDate", "marketType", "selection", "odds"], type: "object", xml: new OA\Xml(name: "BetOdds"))]
#[TableAttribute("bet_odds")]
class BetOdds
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
    #[FieldAttribute(fieldName: "event_name")]
    protected string|null $eventName = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "date-time")]
    #[FieldAttribute(fieldName: "event_date")]
    protected string|null $eventDate = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "string")]
    #[FieldAttribute(fieldName: "market_type")]
    protected string|null $marketType = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "string")]
    #[FieldAttribute(fieldName: "selection")]
    protected string|null $selection = null;

    /**
     * @var float|null
     */
    #[OA\Property(type: "number", format: "double")]
    #[FieldAttribute(fieldName: "odds")]
    protected float|null $odds = null;

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
    #[FieldAttribute(fieldName: "created_at")]
    protected string|null $createdAt = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "date-time", nullable: true)]
    #[FieldAttribute(fieldName: "updated_at")]
    protected string|null $updatedAt = null;



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
     * @return string|null
     */
    public function getEventName(): string|null
    {
        return $this->eventName;
    }

    /**
     * @param string|null $eventName
     * @return $this
     */
    public function setEventName(string|null $eventName): static
    {
        $this->eventName = $eventName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEventDate(): string|null
    {
        return $this->eventDate;
    }

    /**
     * @param string|null $eventDate
     * @return $this
     */
    public function setEventDate(string|null $eventDate): static
    {
        $this->eventDate = $eventDate;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMarketType(): string|null
    {
        return $this->marketType;
    }

    /**
     * @param string|null $marketType
     * @return $this
     */
    public function setMarketType(string|null $marketType): static
    {
        $this->marketType = $marketType;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSelection(): string|null
    {
        return $this->selection;
    }

    /**
     * @param string|null $selection
     * @return $this
     */
    public function setSelection(string|null $selection): static
    {
        $this->selection = $selection;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getOdds(): float|null
    {
        return $this->odds;
    }

    /**
     * @param float|null $odds
     * @return $this
     */
    public function setOdds(float|null $odds): static
    {
        $this->odds = $odds;
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
    public function getCreatedAt(): string|null
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     * @return $this
     */
    public function setCreatedAt(string|null $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUpdatedAt(): string|null
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     * @return $this
     */
    public function setUpdatedAt(string|null $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }


}
