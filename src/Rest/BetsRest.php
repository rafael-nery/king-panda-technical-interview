<?php

namespace RestReferenceArchitecture\Rest;

use ByJG\Config\Exception\ConfigException;
use ByJG\Config\Exception\ConfigNotFoundException;
use ByJG\Config\Exception\DependencyInjectionException;
use ByJG\Config\Exception\InvalidDateException;
use ByJG\Config\Exception\KeyNotFoundException;
use ByJG\MicroOrm\Exception\InvalidArgumentException;
use ByJG\MicroOrm\Exception\OrmBeforeInvalidException;
use ByJG\MicroOrm\Exception\OrmInvalidFieldsException;
use ByJG\RestServer\Exception\Error400Exception;
use ByJG\RestServer\Exception\Error401Exception;
use ByJG\RestServer\Exception\Error403Exception;
use ByJG\RestServer\Exception\Error404Exception;
use ByJG\RestServer\HttpRequest;
use ByJG\RestServer\HttpResponse;
use ByJG\Serializer\ObjectCopy;
use OpenApi\Attributes as OA;
use ReflectionException;
use RestReferenceArchitecture\Model\Bets;
use RestReferenceArchitecture\Psr11;
use RestReferenceArchitecture\Repository\BetsRepository;
use RestReferenceArchitecture\Model\User;
use ByJG\MicroOrm\Literal\HexUuidLiteral;
use RestReferenceArchitecture\Util\JwtContext;
use RestReferenceArchitecture\Util\OpenApiContext;

class BetsRest
{
    /**
     * Get the Bets by id
     *
     * @param HttpResponse $response
     * @param HttpRequest $request
     * @throws ConfigException
     * @throws ConfigNotFoundException
     * @throws DependencyInjectionException
     * @throws Error401Exception
     * @throws Error404Exception
     * @throws InvalidArgumentException
     * @throws InvalidDateException
     * @throws KeyNotFoundException
     * @throws \ByJG\Serializer\Exception\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws ReflectionException
     */
    #[OA\Get(
        path: "/bets/{id}",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bets"],
    )]
    #[OA\Parameter(
        name: "id",
        in: "path",
        required: true,
        schema: new OA\Schema(
            type: "integer",
            format: "int32"
        )
    )]
    #[OA\Response(
        response: 200,
        description: "The object Bets",
        content: new OA\JsonContent(ref: "#/components/schemas/Bets")
    )]
    public function getBets(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireAuthenticated($request);

        $betsRepo = Psr11::get(BetsRepository::class);
        $id = $request->param('id');

        $result = $betsRepo->get($id);
        if (empty($result)) {
            throw new Error404Exception('Id not found');
        }
        $response->write(
            $result
        );
    }

    /**
     * List Bets
     *
     * @param mixed $response
     * @param mixed $request
     * @return void
     * @throws ConfigException
     * @throws ConfigNotFoundException
     * @throws DependencyInjectionException
     * @throws Error401Exception
     * @throws InvalidArgumentException
     * @throws InvalidDateException
     * @throws KeyNotFoundException
     * @throws \ByJG\Serializer\Exception\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws ReflectionException
     */
    #[OA\Get(
        path: "/bets",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bets"]
    )]
    #[OA\Parameter(
        name: "page",
        description: "Page number",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "integer",
        )
    )]
    #[OA\Parameter(
        name: "size",
        description: "Page size",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "integer",
        )
    )]
    #[OA\Parameter(
        name: "orderBy",
        description: "Order by",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "string",
        )
    )]
    #[OA\Parameter(
        name: "filter",
        description: "Filter",
        in: "query",
        required: false,
        schema: new OA\Schema(
            type: "string",
        )
    )]
    #[OA\Response(
        response: 200,
        description: "The object Bets",
        content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/Bets"))
    )]
    #[OA\Response(
        response: 401,
        description: "Not Authorized",
        content: new OA\JsonContent(ref: "#/components/schemas/error")
    )]
    public function listBets(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireAuthenticated($request);

        $repo = Psr11::get(BetsRepository::class);

        $page = $request->get('page');
        $size = $request->get('size');
        // $orderBy = $request->get('orderBy');
        // $filter = $request->get('filter');

        $result = $repo->list($page, $size);
        $response->write(
            $result
        );
    }


    /**
     * Create a new Bets 
     *
     * @param HttpResponse $response
     * @param HttpRequest $request
     * @return void
     * @throws ConfigException
     * @throws ConfigNotFoundException
     * @throws DependencyInjectionException
     * @throws Error400Exception
     * @throws Error401Exception
     * @throws Error403Exception
     * @throws InvalidArgumentException
     * @throws InvalidDateException
     * @throws KeyNotFoundException
     * @throws OrmBeforeInvalidException
     * @throws OrmInvalidFieldsException
     * @throws \ByJG\Serializer\Exception\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws ReflectionException
     */
    #[OA\Post(
        path: "/bets",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bets"]
    )]
    #[OA\RequestBody(
        description: "The object Bets to be created",
        required: true,
        content: new OA\JsonContent(
            required: [ "userId", "betOddsId", "stake", "potentialReturn" ],
            properties: [

                new OA\Property(property: "userId", type: "string", format: "string"),
                new OA\Property(property: "betOddsId", type: "integer", format: "int32"),
                new OA\Property(property: "stake", type: "number", format: "double"),
                new OA\Property(property: "potentialReturn", type: "number", format: "double"),
                new OA\Property(property: "status", type: "string", format: "string", nullable: true),
                new OA\Property(property: "placedAt", type: "string", format: "date-time", nullable: true),
                new OA\Property(property: "settledAt", type: "string", format: "date-time", nullable: true)
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "The object rto be created",
        content: new OA\JsonContent(
            required: [ "id" ],
            properties: [

                new OA\Property(property: "id", type: "integer", format: "int32")
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Not Authorized",
        content: new OA\JsonContent(ref: "#/components/schemas/error")
    )]
    public function postBets(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        $payload = OpenApiContext::validateRequest($request);
        
        $model = new Bets();
        ObjectCopy::copy($payload, $model);

        $betsRepo = Psr11::get(BetsRepository::class);
        $betsRepo->save($model);

        $response->write([ "id" => $model->getId()]);
    }


    /**
     * Update an existing Bets 
     *
     * @param HttpResponse $response
     * @param HttpRequest $request
     * @return void
     * @throws Error401Exception
     * @throws Error404Exception
     * @throws ConfigException
     * @throws ConfigNotFoundException
     * @throws DependencyInjectionException
     * @throws InvalidDateException
     * @throws KeyNotFoundException
     * @throws InvalidArgumentException
     * @throws OrmBeforeInvalidException
     * @throws OrmInvalidFieldsException
     * @throws Error400Exception
     * @throws Error403Exception
     * @throws \ByJG\Serializer\Exception\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws ReflectionException
     */
    #[OA\Put(
        path: "/bets",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bets"]
    )]
    #[OA\RequestBody(
        description: "The object Bets to be updated",
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/Bets")
    )]
    #[OA\Response(
        response: 200,
        description: "Nothing to return"
    )]
    #[OA\Response(
        response: 401,
        description: "Not Authorized",
        content: new OA\JsonContent(ref: "#/components/schemas/error")
    )]
    public function putBets(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        $payload = OpenApiContext::validateRequest($request);

        $betsRepo = Psr11::get(BetsRepository::class);
        $model = $betsRepo->get($payload['id']);
        if (empty($model)) {
            throw new Error404Exception('Id not found');
        }
        ObjectCopy::copy($payload, $model);

        $betsRepo->save($model);
    }

    /**
     * @param HttpResponse $response
     * @param HttpRequest $request
     * @return array
     * @throws Error401Exception
     * @throws Error403Exception
     * @throws \ByJG\Serializer\Exception\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws ReflectionException
     */
    #[OA\Get(
        path: "/my/bets",
        security: [["jwt-token" => []]],
        tags: ["Bets"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List user's bets",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Bets")
                )
            ),
            new OA\Response(response: 401, description: "Unauthorized"),
            new OA\Response(response: 403, description: "Forbidden")
        ]
    )]
    public function getMyBets(HttpResponse $response, HttpRequest $request): array
    {
        JwtContext::requireAuthenticated($request);

        // Get user ID from JWT token
        $userId = new HexUuidLiteral(JwtContext::getUserId());

        $betsRepo = Psr11::get(BetsRepository::class);
        $result = $betsRepo->getByUserId($userId);

        return $result;
    }

}
