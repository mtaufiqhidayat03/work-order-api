<?php

class WorkOrderTest extends TestCase
{
    public function testShouldReturnAllWorkOrder() {
        $this->withoutMiddleware();
        $this->get('/api-v1/show-workorder',[]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    '_id',
                    'woid',
                    'wo_name',
                    'prodid',
                    'customerid',
                    'prod_start_date'
                ]
            ]
        ]);
    }

    public function testShouldReturnWorkOrder() {
        $this->withoutMiddleware();
        $this->get("/api-v1/get-workorder/365253820",[]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' =>
                [
                    '_id',
                    'woid',
                    'wo_name',
                    'prodid',
                    'customerid',
                    'prod_start_date'
                ]
            ]
        ]);
    }

    public function testShouldCreateWorkOrder()
    {
        $this->withoutMiddleware();
        $parameters = [
            'woid' => '999',
            'wo_name' => '999test',
            'prodid' => '999',
            'customerid' => 'cs999',
            'prod_start_date' => '2021-02-01 01:01:01'
        ];
        $this->post("/api-v1/save-workorder", $parameters, []);
        $this->seeStatusCode(200);
    }
}
