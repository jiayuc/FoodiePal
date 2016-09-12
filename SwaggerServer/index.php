<?php
/**
 * Experiment try
 * @version 2.0
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = new Slim\App();


/**
 * DELETE canceljob
 * Summary: Cancel a job
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->DELETE('/jobs/{jobId}?api-version&#x3D;2.0', function($request, $response, $args) {
            
            
            
            
            $response->write('How about implementing canceljob as a DELETE method ?');
            return $response;
            });


/**
 * POST execute
 * Summary: Execute the web service and get a response synchronously
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->POST('/execute?api-version&#x3D;2.0&amp;format&#x3D;swagger', function($request, $response, $args) {
            
            
            
            $body = $request->getParsedBody();
            $response->write('How about implementing execute as a POST method ?');
            return $response;
            });


/**
 * GET getSwaggerDocument
 * Summary: Get swagger API document for the web service
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->GET('/swagger.json', function($request, $response, $args) {
            
            $queryParams = $request->getQueryParams();
            $apiVersion = $queryParams['apiVersion'];    
            
            
            $response->write('How about implementing getSwaggerDocument as a GET method ?');
            return $response;
            });


/**
 * GET getjobstatus
 * Summary: Get the status for a give job
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->GET('/jobs/{jobId}?api-version&#x3D;2.0', function($request, $response, $args) {
            
            
            
            
            $response->write('How about implementing getjobstatus as a GET method ?');
            return $response;
            });


/**
 * POST startjob
 * Summary: Start running a job
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->POST('/jobs/{jobId}/start?api-version&#x3D;2.0', function($request, $response, $args) {
            
            
            
            
            $response->write('How about implementing startjob as a POST method ?');
            return $response;
            });


/**
 * POST submitjob
 * Summary: Submit an asynchronous job to execute the web service
 * Notes: 
 * Output-Formats: [application/json]
 */
$app->POST('/jobs?api-version&#x3D;2.0', function($request, $response, $args) {
            
            
            
            $body = $request->getParsedBody();
            $response->write('How about implementing submitjob as a POST method ?');
            return $response;
            });



$app->run();
