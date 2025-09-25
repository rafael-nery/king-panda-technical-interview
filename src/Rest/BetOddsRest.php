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
use RestReferenceArchitecture\Model\BetOdds;
use RestReferenceArchitecture\Psr11;
use RestReferenceArchitecture\Repository\BetOddsRepository;
use RestReferenceArchitecture\Model\User;
use RestReferenceArchitecture\Util\JwtContext;
use RestReferenceArchitecture\Util\OpenApiContext;

class BetOddsRest
{
    /**
     * Get the BetOdds by id
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
        path: "/bet/odds/{id}",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bet"],
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
        description: "The object BetOdds",
        content: new OA\JsonContent(ref: "#/components/schemas/BetOdds")
    )]
    public function getBetOdds(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireAuthenticated($request);

        $betOddsRepo = Psr11::get(BetOddsRepository::class);
        $id = $request->param('id');

        $result = $betOddsRepo->get($id);
        if (empty($result)) {
            throw new Error404Exception('Id not found');
        }
        $response->write(
            $result
        );
    }

    /**
     * List BetOdds
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
        path: "/bet/odds",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bet"]
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
        description: "The object BetOdds",
        content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/BetOdds"))
    )]
    #[OA\Response(
        response: 401,
        description: "Not Authorized",
        content: new OA\JsonContent(ref: "#/components/schemas/error")
    )]
    public function listBetOdds(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireAuthenticated($request);

        $repo = Psr11::get(BetOddsRepository::class);

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
     * Create a new BetOdds 
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
        path: "/bet/odds",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bet"]
    )]
    #[OA\RequestBody(
        description: "The object BetOdds to be created",
        required: true,
        content: new OA\JsonContent(
            required: [ "eventName", "eventDate", "marketType", "selection", "odds" ],
            properties: [

                new OA\Property(property: "eventName", type: "string", format: "string"),
                new OA\Property(property: "eventDate", type: "string", format: "date-time"),
                new OA\Property(property: "marketType", type: "string", format: "string"),
                new OA\Property(property: "selection", type: "string", format: "string"),
                new OA\Property(property: "odds", type: "number", format: "double"),
                new OA\Property(property: "status", type: "string", format: "string", nullable: true),
                new OA\Property(property: "createdAt", type: "string", format: "date-time", nullable: true),
                new OA\Property(property: "updatedAt", type: "string", format: "date-time", nullable: true)
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
    public function postBetOdds(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        $payload = OpenApiContext::validateRequest($request);
        
        $model = new BetOdds();
        ObjectCopy::copy($payload, $model);

        $betOddsRepo = Psr11::get(BetOddsRepository::class);
        $betOddsRepo->save($model);

        $response->write([ "id" => $model->getId()]);
    }


    /**
     * Update an existing BetOdds 
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
        path: "/bet/odds",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Bet"]
    )]
    #[OA\RequestBody(
        description: "The object BetOdds to be updated",
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/BetOdds")
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
    public function putBetOdds(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        $payload = OpenApiContext::validateRequest($request);

        $betOddsRepo = Psr11::get(BetOddsRepository::class);
        $model = $betOddsRepo->get($payload['id']);
        if (empty($model)) {
            throw new Error404Exception('Id not found');
        }
        ObjectCopy::copy($payload, $model);

        $betOddsRepo->save($model);
    }

    /**
     * @param HttpResponse $response
     * @param HttpRequest $request
     * @return array
     * @throws \ByJG\RestServer\Exception\Error401Exception
     * @throws \ByJG\RestServer\Exception\Error403Exception
     * @throws \ByJG\Serializer\Exception\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     */
    #[OA\Get(
        path: "/bet/odds/active",
        security: [["jwt-token" => []]],
        tags: ["BetOdds"],
        responses: [
            new OA\Response(
                response: 200,
                description: "List active odds",
                content: new OA\JsonContent(
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/BetOdds")
                )
            ),
            new OA\Response(response: 401, description: "Unauthorized"),
            new OA\Response(response: 403, description: "Forbidden")
        ]
    )]
    public function getActive(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireAuthenticated($request);

        $betOddsRepo = Psr11::get(BetOddsRepository::class);
        $result = $betOddsRepo->getByStatus('active');

        $response->write($result);
    }

    /**
     * @param HttpResponse $response
     * @param HttpRequest $request
     * @return array
     * @throws Error404Exception
     * @throws \ByJG\RestServer\Exception\Error401Exception
     * @throws \ByJG\RestServer\Exception\Error403Exception
     * @throws \ByJG\Serializer\Exception\InvalidArgumentException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \ReflectionException
     */
    #[OA\Put(
        path: "/bet/odds/{id}/suspend",
        security: [["jwt-token" => []]],
        tags: ["BetOdds"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Odd suspended successfully",
                content: new OA\JsonContent(
                    type: "object",
                    properties: [
                        new OA\Property(property: "id", type: "integer"),
                        new OA\Property(property: "event_name", type: "string"),
                        new OA\Property(property: "status", type: "string"),
                        new OA\Property(property: "message", type: "string")
                    ]
                )
            ),
            new OA\Response(response: 401, description: "Unauthorized"),
            new OA\Response(response: 403, description: "Insufficient privileges"),
            new OA\Response(response: 404, description: "Odd not found")
        ]
    )]
    public function suspend(HttpResponse $response, HttpRequest $request): array
    {
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        $id = $request->param('id');
        $betOddsRepo = Psr11::get(BetOddsRepository::class);
        $model = $betOddsRepo->get($id);

        if (empty($model)) {
            throw new Error404Exception('Odd not found');
        }

        $model->setStatus('suspended');
        $betOddsRepo->save($model);

        return [
            'id' => $model->getId(),
            'event_name' => $model->getEventName(),
            'status' => $model->getStatus(),
            'message' => 'Odd suspended successfully'
        ];
    }

}
