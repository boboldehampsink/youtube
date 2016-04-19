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
 * The "attachments" collection of methods.
 * Typical usage is:
 *  <code>
 *   $proximitybeaconService = new Google_Service_Proximitybeacon(...);
 *   $attachments = $proximitybeaconService->attachments;
 *  </code>
 */
class Google_Service_Proximitybeacon_BeaconsAttachmentsResource extends Google_Service_Resource
{
  /**
   * Deletes multiple attachments on a given beacon. This operation is permanent
   * and cannot be undone. You can optionally specify `namespacedType` to choose
   * which attachments should be deleted. If you do not specify `namespacedType`,
   * all your attachments on the given beacon will be deleted. You also may
   * explicitly specify `*` to delete all. (attachments.batchDelete)
   *
   * @param string $beaconName The beacon whose attachments are to be deleted.
   * Required.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string namespacedType Specifies the namespace and type of
   * attachments to delete in `namespace/type` format. Accepts `*` to specify "all
   * types in all namespaces". Optional.
   * @return Google_Service_DeleteAttachmentsResponse
   */
  public function batchDelete($beaconName, $optParams = array())
  {
    $params = array('beaconName' => $beaconName);
    $params = array_merge($params, $optParams);
    return $this->call('batchDelete', array($params), "Google_Service_Proximitybeacon_DeleteAttachmentsResponse");
  }
  /**
   * Associates the given data with the specified beacon. Attachment data must
   * contain two parts: - A namespaced type.  - The actual attachment data itself.
   * The namespaced type consists of two parts, the namespace and the type. The
   * namespace must be one of the values returned by the `namespaces` endpoint,
   * while the type can be a string of any characters except for the forward slash
   * (`/`) up to 100 characters in length. Attachment data can be up to 1024 bytes
   * long. (attachments.create)
   *
   * @param string $beaconName The beacon on which the attachment should be
   * created. Required.
   * @param Google_BeaconAttachment $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_BeaconAttachment
   */
  public function create($beaconName, Google_Service_Proximitybeacon_BeaconAttachment $postBody, $optParams = array())
  {
    $params = array('beaconName' => $beaconName, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('create', array($params), "Google_Service_Proximitybeacon_BeaconAttachment");
  }
  /**
   * Deletes the specified attachment for the given beacon. Each attachment has a
   * unique attachment name (`attachmentName`) which is returned when you fetch
   * the attachment data via this API. You specify this with the delete request to
   * control which attachment is removed. This operation cannot be undone.
   * (attachments.delete)
   *
   * @param string $attachmentName The attachment name (`attachmentName`) of the
   * attachment to remove. For example:
   * `beacons/3!893737abc9/attachments/c5e937-af0-494-959-ec49d12738` Required.
   * @param array $optParams Optional parameters.
   * @return Google_Service_ProximitybeaconEmpty
   */
  public function delete($attachmentName, $optParams = array())
  {
    $params = array('attachmentName' => $attachmentName);
    $params = array_merge($params, $optParams);
    return $this->call('delete', array($params), "Google_Service_Proximitybeacon_ProximitybeaconEmpty");
  }
  /**
   * Returns the attachments for the specified beacon that match the specified
   * namespaced-type pattern. To control which namespaced types are returned, you
   * add the `namespacedType` query parameter to the request. You must either use
   * `*`, to return all attachments, or the namespace must be one of the ones
   * returned from the `namespaces` endpoint. (attachments.listBeaconsAttachments)
   *
   * @param string $beaconName The beacon whose attachments are to be fetched.
   * Required.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string namespacedType Specifies the namespace and type of
   * attachment to include in response in namespace/type format. Accepts `*` to
   * specify "all types in all namespaces".
   * @return Google_Service_ListBeaconAttachmentsResponse
   */
  public function listBeaconsAttachments($beaconName, $optParams = array())
  {
    $params = array('beaconName' => $beaconName);
    $params = array_merge($params, $optParams);
    return $this->call('list', array($params), "Google_Service_Proximitybeacon_ListBeaconAttachmentsResponse");
  }
}
