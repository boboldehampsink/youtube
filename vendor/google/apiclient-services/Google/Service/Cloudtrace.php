<?php
/*
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

/**
 * Service definition for Cloudtrace (v1).
 *
 * <p>
 * The Cloud Trace API allows you to send traces to and retrieve traces from
 * Google Cloud Trace.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://cloud.google.com/tools/cloud-trace" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Cloudtrace extends Google_Service
{
  /** View and manage your data across Google Cloud Platform services. */
  const CLOUD_PLATFORM =
      "https://www.googleapis.com/auth/cloud-platform";

  public $projects;
  public $projects_traces;
  
  /**
   * Constructs the internal representation of the Cloudtrace service.
   *
   * @param Google_Client $client
   */
  public function __construct(Google_Client $client)
  {
    parent::__construct($client);
    $this->rootUrl = 'https://cloudtrace.googleapis.com/';
    $this->servicePath = '';
    $this->version = 'v1';
    $this->serviceName = 'cloudtrace';

    $this->projects = new Google_Service_Cloudtrace_ProjectsResource(
        $this,
        $this->serviceName,
        'projects',
        array(
          'methods' => array(
            'patchTraces' => array(
              'path' => 'v1/projects/{projectId}/traces',
              'httpMethod' => 'PATCH',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
    $this->projects_traces = new Google_Service_Cloudtrace_ProjectsTracesResource(
        $this,
        $this->serviceName,
        'traces',
        array(
          'methods' => array(
            'get' => array(
              'path' => 'v1/projects/{projectId}/traces/{traceId}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'traceId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1/projects/{projectId}/traces',
              'httpMethod' => 'GET',
              'parameters' => array(
                'projectId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'view' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'pageSize' => array(
                  'location' => 'query',
                  'type' => 'integer',
                ),
                'pageToken' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'startTime' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'endTime' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'filter' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'orderBy' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),
          )
        )
    );
  }
}
