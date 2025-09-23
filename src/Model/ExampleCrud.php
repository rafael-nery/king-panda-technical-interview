<?php

namespace RestReferenceArchitecture\Model;

use ByJG\MicroOrm\Attributes\FieldAttribute;
use ByJG\MicroOrm\Attributes\FieldUuidAttribute;
use ByJG\MicroOrm\Attributes\TableAttribute;
use ByJG\MicroOrm\Attributes\TableMySqlUuidPKAttribute;
use ByJG\MicroOrm\Literal\HexUuidLiteral;
use OpenApi\Attributes as OA;

/**
 * Class ExampleCrud
 * @package RestReferenceArchitecture\Model
 */
#[OA\Schema(required: ["id", "name"], type: "object", xml: new OA\Xml(name: "ExampleCrud"))]
#[TableAttribute("example_crud")]
class ExampleCrud
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
    #[FieldAttribute(fieldName: "name")]
    protected string|null $name = null;

    /**
     * @var string|null
     */
    #[OA\Property(type: "string", format: "date-time", nullable: true)]
    #[FieldAttribute(fieldName: "birthdate")]
    protected string|null $birthdate = null;

    /**
     * @var int|null
     */
    #[OA\Property(type: "integer", format: "int32", nullable: true)]
    #[FieldAttribute(fieldName: "code")]
    protected int|null $code = null;



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
    public function getName(): string|null
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return $this
     */
    public function setName(string|null $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBirthdate(): string|null
    {
        return $this->birthdate;
    }

    /**
     * @param string|null $birthdate
     * @return $this
     */
    public function setBirthdate(string|null $birthdate): static
    {
        $this->birthdate = $birthdate;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getCode(): int|null
    {
        return $this->code;
    }

    /**
     * @param int|null $code
     * @return $this
     */
    public function setCode(int|null $code): static
    {
        $this->code = $code;
        return $this;
    }


}
