<?php

namespace Test\Rest;

use ByJG\RestServer\Exception\Error401Exception;
use ByJG\RestServer\Exception\Error403Exception;
use ByJG\Serializer\ObjectCopy;
use RestReferenceArchitecture\Util\FakeApiRequester;
use RestReferenceArchitecture\Model\BetOdds;
use RestReferenceArchitecture\Repository\BaseRepository;

class BetOddsTest extends BaseApiTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @return BetOdds|array
     */
    protected function getSampleData($array = false)
    {
        $sample = [

            'eventName' => 'Flamengo vs Vasco',
            'eventDate' => '2025-10-01 19:00:00',
            'marketType' => '1X2',
            'selection' => 'Home',
            'odds' => 1.85,
            'status' => 'active',
            'createdAt' => '2025-09-23 12:00:00',
            'updatedAt' => '2025-09-23 12:00:00',
        ];

        if ($array) {
            return $sample;
        }

        ObjectCopy::copy($sample, $model = new BetOdds());
        return $model;
    }



    public function testGetUnauthorized()
    {
        $this->expectException(Error401Exception::class);
        $this->expectExceptionMessage('Absent authorization token');

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('GET')
            ->withPath("/bet/odds/1")
            ->assertResponseCode(401)
        ;
        $this->assertRequest($request);
    }

    public function testListUnauthorized()
    {
        $this->expectException(Error401Exception::class);
        $this->expectExceptionMessage('Absent authorization token');

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('GET')
            ->withPath("/bet/odds/1")
            ->assertResponseCode(401)
        ;
        $this->assertRequest($request);
    }

    public function testPostUnauthorized()
    {
        $this->expectException(Error401Exception::class);
        $this->expectExceptionMessage('Absent authorization token');

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('POST')
            ->withPath("/bet/odds")
            ->withRequestBody(json_encode($this->getSampleData(true)))
            ->assertResponseCode(401)
        ;
        $this->assertRequest($request);
    }

    public function testPutUnauthorized()
    {
        $this->expectException(Error401Exception::class);
        $this->expectExceptionMessage('Absent authorization token');

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('PUT')
            ->withPath("/bet/odds")
            ->withRequestBody(json_encode($this->getSampleData(true) + ['id' => 1]))
            ->assertResponseCode(401)
        ;
        $this->assertRequest($request);
    }

    public function testPostInsufficientPrivileges()
    {
        $this->expectException(Error403Exception::class);
        $this->expectExceptionMessage('Insufficient privileges');

        $result = json_decode($this->assertRequest(Credentials::requestLogin(Credentials::getRegularUser()))->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('POST')
            ->withPath("/bet/odds")
            ->withRequestBody(json_encode($this->getSampleData(true)))
            ->assertResponseCode(403)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $this->assertRequest($request);
    }

    public function testPutInsufficientPrivileges()
    {
        $this->expectException(Error403Exception::class);
        $this->expectExceptionMessage('Insufficient privileges');

        $result = json_decode($this->assertRequest(Credentials::requestLogin(Credentials::getRegularUser()))->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('PUT')
            ->withPath("/bet/odds")
            ->withRequestBody(json_encode($this->getSampleData(true) + ['id' => 1]))
            ->assertResponseCode(403)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $this->assertRequest($request);
    }

    public function testFullCrud()
    {
        $result = json_decode($this->assertRequest(Credentials::requestLogin(Credentials::getAdminUser()))->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('POST')
            ->withPath("/bet/odds")
            ->withRequestBody(json_encode($this->getSampleData(true)))
            ->assertResponseCode(200)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $body = $this->assertRequest($request);
        $bodyAr = json_decode($body->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('GET')
            ->withPath("/bet/odds/" . $bodyAr['id'])
            ->assertResponseCode(200)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $body = $this->assertRequest($request);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('PUT')
            ->withPath("/bet/odds")
            ->withRequestBody($body->getBody()->getContents())
            ->assertResponseCode(200)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $this->assertRequest($request);
    }

    public function testList()
    {
        $result = json_decode($this->assertRequest(Credentials::requestLogin(Credentials::getRegularUser()))->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('GET')
            ->withPath("/bet/odds")
            ->assertResponseCode(200)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $this->assertRequest($request);
    }

    public function testGetActiveOdds()
    {
        $result = json_decode($this->assertRequest(Credentials::requestLogin(Credentials::getRegularUser()))->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('GET')
            ->withPath("/bet/odds/active")
            ->assertResponseCode(200)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $this->assertRequest($request);
    }

    public function testSuspendOddAsAdmin()
    {
        // First create an odd
        $result = json_decode($this->assertRequest(Credentials::requestLogin(Credentials::getAdminUser()))->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('POST')
            ->withPath("/bet/odds")
            ->withRequestBody(json_encode($this->getSampleData(true)))
            ->assertResponseCode(200)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $body = $this->assertRequest($request);
        $bodyAr = json_decode($body->getBody()->getContents(), true);

        // Then suspend it
        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('PUT')
            ->withPath("/bet/odds/" . $bodyAr['id'] . "/suspend")
            ->assertResponseCode(200)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $this->assertRequest($request);
        // The endpoint should execute successfully
    }

    public function testSuspendOddAsUserForbidden()
    {
        $this->expectException(Error403Exception::class);
        $this->expectExceptionMessage('Insufficient privileges');

        $result = json_decode($this->assertRequest(Credentials::requestLogin(Credentials::getRegularUser()))->getBody()->getContents(), true);

        $request = new FakeApiRequester();
        $request
            ->withPsr7Request($this->getPsr7Request())
            ->withMethod('PUT')
            ->withPath("/bet/odds/1/suspend")
            ->assertResponseCode(403)
            ->withRequestHeader([
                "Authorization" => "Bearer " . $result['token']
            ])
        ;
        $this->assertRequest($request);
    }
}
