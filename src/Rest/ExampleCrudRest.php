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
use RestReferenceArchitecture\Model\ExampleCrud;
use RestReferenceArchitecture\Psr11;
use RestReferenceArchitecture\Repository\ExampleCrudRepository;
use RestReferenceArchitecture\Model\User;
use RestReferenceArchitecture\Util\JwtContext;
use RestReferenceArchitecture\Util\OpenApiContext;

class ExampleCrudRest
{
    /**
     * Get the ExampleCrud by id
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
        path: "/example/crud/{id}",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Example"],
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
        description: "The object ExampleCrud",
        content: new OA\JsonContent(ref: "#/components/schemas/ExampleCrud")
    )]
    public function getExampleCrud(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireAuthenticated($request);

        $exampleCrudRepo = Psr11::get(ExampleCrudRepository::class);
        $id = $request->param('id');

        $result = $exampleCrudRepo->get($id);
        if (empty($result)) {
            throw new Error404Exception('Id not found');
        }
        $response->write(
            $result
        );
    }

    /**
     * List ExampleCrud
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
        path: "/example/crud",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Example"]
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
        description: "The object ExampleCrud",
        content: new OA\JsonContent(type: "array", items: new OA\Items(ref: "#/components/schemas/ExampleCrud"))
    )]
    #[OA\Response(
        response: 401,
        description: "Not Authorized",
        content: new OA\JsonContent(ref: "#/components/schemas/error")
    )]
    public function listExampleCrud(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireAuthenticated($request);

        $repo = Psr11::get(ExampleCrudRepository::class);

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
     * Create a new ExampleCrud 
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
        path: "/example/crud",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Example"]
    )]
    #[OA\RequestBody(
        description: "The object ExampleCrud to be created",
        required: true,
        content: new OA\JsonContent(
            required: [ "name" ],
            properties: [

                new OA\Property(property: "name", type: "string", format: "string"),
                new OA\Property(property: "birthdate", type: "string", format: "date-time", nullable: true),
                new OA\Property(property: "code", type: "integer", format: "int32", nullable: true),
                new OA\Property(property: "status", type: "string", format: "string", nullable: true)
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
    public function postExampleCrud(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        $payload = OpenApiContext::validateRequest($request);
        
        $model = new ExampleCrud();
        ObjectCopy::copy($payload, $model);

        $exampleCrudRepo = Psr11::get(ExampleCrudRepository::class);
        $exampleCrudRepo->save($model);

        $response->write([ "id" => $model->getId()]);
    }


    /**
     * Update an existing ExampleCrud 
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
        path: "/example/crud",
        security: [
            ["jwt-token" => []]
        ],
        tags: ["Example"]
    )]
    #[OA\RequestBody(
        description: "The object ExampleCrud to be updated",
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/ExampleCrud")
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
    public function putExampleCrud(HttpResponse $response, HttpRequest $request): void
    {
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        $payload = OpenApiContext::validateRequest($request);

        $exampleCrudRepo = Psr11::get(ExampleCrudRepository::class);
        $model = $exampleCrudRepo->get($payload['id']);
        if (empty($model)) {
            throw new Error404Exception('Id not found');
        }
        ObjectCopy::copy($payload, $model);

        $exampleCrudRepo->save($model);
    }

    /**
     * Custom method to update only the status of an ExampleCrud record
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
        path: "/example/crud/status",
        security: [["jwt-token" => []]],
        tags: ["Example"],
        description: "Update the status of the ExampleCrud"
    )]
    #[OA\RequestBody(
        description: "The status to be updated",
        required: true,
        content: new OA\JsonContent(
            required: ["id", "status"],
            properties: [
                new OA\Property(property: "id", type: "integer", format: "int32"),
                new OA\Property(property: "status", type: "string", maxLength: 10)
            ]
        )
    )]
    #[OA\Response(
        response: 200,
        description: "The operation result",
        content: new OA\JsonContent(
            required: ["result"],
            properties: [
                new OA\Property(property: "result", type: "string")
            ]
        )
    )]
    #[OA\Response(
        response: 401,
        description: "Not Authorized",
        content: new OA\JsonContent(ref: "#/components/schemas/error")
    )]
    #[OA\Response(
        response: 404,
        description: "Record not found",
        content: new OA\JsonContent(ref: "#/components/schemas/error")
    )]
    public function putExampleCrudStatus(HttpResponse $response, HttpRequest $request): void
    {
        // Secure the endpoint - require admin role
        JwtContext::requireRole($request, User::ROLE_ADMIN);

        // Validate request payload
        $payload = OpenApiContext::validateRequest($request);

        // Get the repository and find the record
        $exampleCrudRepo = Psr11::get(ExampleCrudRepository::class);
        $model = $exampleCrudRepo->get($payload["id"]);

        // Check if record exists
        if (!$model) {
            throw new Error404Exception("Record not found");
        }

        // Update only the status field
        $model->setStatus($payload["status"]);
        $exampleCrudRepo->save($model);

        // Return success response
        $response->write([
            "result" => "Status updated successfully"
        ]);
    }

}
