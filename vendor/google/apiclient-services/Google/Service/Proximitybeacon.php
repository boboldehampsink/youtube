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
 * Service definition for Proximitybeacon (v1beta1).
 *
 * <p>
 * This API provides services to register, manage, index, and search beacons.</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://developers.google.com/beacons/proximity/" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Proximitybeacon extends Google_Service
{


  public $beaconinfo;
  public $beacons;
  public $beacons_attachments;
  public $beacons_diagnostics;
  public $namespaces;
  
  /**
   * Constructs the internal representation of the Proximitybeacon service.
   *
   * @param Google_Client $client
   */
  public function __construct(Google_Client $client)
  {
    parent::__construct($client);
    $this->rootUrl = 'https://proximitybeacon.googleapis.com/';
    $this->servicePath = '';
    $this->version = 'v1beta1';
    $this->serviceName = 'proximitybeacon';

    $this->beaconinfo = new Google_Service_Proximitybeacon_BeaconinfoResource(
        $this,
        $this->serviceName,
        'beaconinfo',
        array(
          'methods' => array(
            'getforobserved' => array(
              'path' => 'v1beta1/beaconinfo:getforobserved',
              'httpMethod' => 'POST',
              'parameters' => array(),
            ),
          )
        )
    );
    $this->beacons = new Google_Service_Proximitybeacon_BeaconsResource(
        $this,
        $this->serviceName,
        'beacons',
        array(
          'methods' => array(
            'activate' => array(
              'path' => 'v1beta1/{+beaconName}:activate',
              'httpMethod' => 'POST',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'deactivate' => array(
              'path' => 'v1beta1/{+beaconName}:deactivate',
              'httpMethod' => 'POST',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'decommission' => array(
              'path' => 'v1beta1/{+beaconName}:decommission',
              'httpMethod' => 'POST',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'get' => array(
              'path' => 'v1beta1/{+beaconName}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1beta1/beacons',
              'httpMethod' => 'GET',
              'parameters' => array(
                'q' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'pageToken' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'pageSize' => array(
                  'location' => 'query',
                  'type' => 'integer',
                ),
              ),
            ),'register' => array(
              'path' => 'v1beta1/beacons:register',
              'httpMethod' => 'POST',
              'parameters' => array(),
            ),'update' => array(
              'path' => 'v1beta1/{+beaconName}',
              'httpMethod' => 'PUT',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
    $this->beacons_attachments = new Google_Service_Proximitybeacon_BeaconsAttachmentsResource(
        $this,
        $this->serviceName,
        'attachments',
        array(
          'methods' => array(
            'batchDelete' => array(
              'path' => 'v1beta1/{+beaconName}/attachments:batchDelete',
              'httpMethod' => 'POST',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'namespacedType' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'create' => array(
              'path' => 'v1beta1/{+beaconName}/attachments',
              'httpMethod' => 'POST',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'delete' => array(
              'path' => 'v1beta1/{+attachmentName}',
              'httpMethod' => 'DELETE',
              'parameters' => array(
                'attachmentName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1beta1/{+beaconName}/attachments',
              'httpMethod' => 'GET',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'namespacedType' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),
          )
        )
    );
    $this->beacons_diagnostics = new Google_Service_Proximitybeacon_BeaconsDiagnosticsResource(
        $this,
        $this->serviceName,
        'diagnostics',
        array(
          'methods' => array(
            'list' => array(
              'path' => 'v1beta1/{+beaconName}/diagnostics',
              'httpMethod' => 'GET',
              'parameters' => array(
                'beaconName' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'pageSize' => array(
                  'location' => 'query',
                  'type' => 'integer',
                ),
                'pageToken' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'alertFilter' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),
          )
        )
    );
    $this->namespaces = new Google_Service_Proximitybeacon_NamespacesResource(
        $this,
        $this->serviceName,
        'namespaces',
        array(
          'methods' => array(
            'list' => array(
              'path' => 'v1beta1/namespaces',
              'httpMethod' => 'GET',
              'parameters' => array(),
            ),
          )
        )
    );
  }
}
