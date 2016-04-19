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
 * The "products" collection of methods.
 * Typical usage is:
 *  <code>
 *   $androidenterpriseService = new Google_Service_AndroidEnterprise(...);
 *   $products = $androidenterpriseService->products;
 *  </code>
 */
class Google_Service_AndroidEnterprise_ProductsResource extends Google_Service_Resource
{
  /**
   * Approves the specified product (and the relevant app permissions, if any).
   * (products.approve)
   *
   * @param string $enterpriseId The ID of the enterprise.
   * @param string $productId The ID of the product.
   * @param Google_ProductsApproveRequest $postBody
   * @param array $optParams Optional parameters.
   */
  public function approve($enterpriseId, $productId, Google_Service_AndroidEnterprise_ProductsApproveRequest $postBody, $optParams = array())
  {
    $params = array('enterpriseId' => $enterpriseId, 'productId' => $productId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('approve', array($params));
  }
  /**
   * Generates a URL that can be rendered in an iframe to display the permissions
   * (if any) of a product. An enterprise admin must view these permissions and
   * accept them on behalf of their organization in order to approve that product.
   *
   * Admins should accept the displayed permissions by interacting with a separate
   * UI element in the EMM console, which in turn should trigger the use of this
   * URL as the approvalUrlInfo.approvalUrl property in a Products.approve call to
   * approve the product. This URL can only be used to display permissions for up
   * to 1 day. (products.generateApprovalUrl)
   *
   * @param string $enterpriseId The ID of the enterprise.
   * @param string $productId The ID of the product.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string languageCode The BCP 47 language code used for permission
   * names and descriptions in the returned iframe, for instance "en-US".
   * @return Google_Service_ProductsGenerateApprovalUrlResponse
   */
  public function generateApprovalUrl($enterpriseId, $productId, $optParams = array())
  {
    $params = array('enterpriseId' => $enterpriseId, 'productId' => $productId);
    $params = array_merge($params, $optParams);
    return $this->call('generateApprovalUrl', array($params), "Google_Service_AndroidEnterprise_ProductsGenerateApprovalUrlResponse");
  }
  /**
   * Retrieves details of a product for display to an enterprise admin.
   * (products.get)
   *
   * @param string $enterpriseId The ID of the enterprise.
   * @param string $productId The ID of the product, e.g.
   * "app:com.google.android.gm".
   * @param array $optParams Optional parameters.
   *
   * @opt_param string language The BCP47 tag for the user's preferred language
   * (e.g. "en-US", "de").
   * @return Google_Service_Product
   */
  public function get($enterpriseId, $productId, $optParams = array())
  {
    $params = array('enterpriseId' => $enterpriseId, 'productId' => $productId);
    $params = array_merge($params, $optParams);
    return $this->call('get', array($params), "Google_Service_AndroidEnterprise_Product");
  }
  /**
   * Retrieves the schema defining app restrictions configurable for this product.
   * All products have a schema, but this may be empty if no app restrictions are
   * defined. (products.getAppRestrictionsSchema)
   *
   * @param string $enterpriseId The ID of the enterprise.
   * @param string $productId The ID of the product.
   * @param array $optParams Optional parameters.
   *
   * @opt_param string language The BCP47 tag for the user's preferred language
   * (e.g. "en-US", "de").
   * @return Google_Service_AppRestrictionsSchema
   */
  public function getAppRestrictionsSchema($enterpriseId, $productId, $optParams = array())
  {
    $params = array('enterpriseId' => $enterpriseId, 'productId' => $productId);
    $params = array_merge($params, $optParams);
    return $this->call('getAppRestrictionsSchema', array($params), "Google_Service_AndroidEnterprise_AppRestrictionsSchema");
  }
  /**
   * Retrieves the Android app permissions required by this app.
   * (products.getPermissions)
   *
   * @param string $enterpriseId The ID of the enterprise.
   * @param string $productId The ID of the product.
   * @param array $optParams Optional parameters.
   * @return Google_Service_ProductPermissions
   */
  public function getPermissions($enterpriseId, $productId, $optParams = array())
  {
    $params = array('enterpriseId' => $enterpriseId, 'productId' => $productId);
    $params = array_merge($params, $optParams);
    return $this->call('getPermissions', array($params), "Google_Service_AndroidEnterprise_ProductPermissions");
  }
  /**
   * This method has been deprecated. To programmatically approve applications,
   * you must use the iframe mechanism via the  generateApprovalUrl and  approve
   * methods of the Products resource. For more information, see the  Play EMM API
   * usage requirements.
   *
   * The updatePermissions method (deprecated) updates the set of Android app
   * permissions for this app that have been accepted by the enterprise.
   * (products.updatePermissions)
   *
   * @param string $enterpriseId The ID of the enterprise.
   * @param string $productId The ID of the product.
   * @param Google_ProductPermissions $postBody
   * @param array $optParams Optional parameters.
   * @return Google_Service_ProductPermissions
   */
  public function updatePermissions($enterpriseId, $productId, Google_Service_AndroidEnterprise_ProductPermissions $postBody, $optParams = array())
  {
    $params = array('enterpriseId' => $enterpriseId, 'productId' => $productId, 'postBody' => $postBody);
    $params = array_merge($params, $optParams);
    return $this->call('updatePermissions', array($params), "Google_Service_AndroidEnterprise_ProductPermissions");
  }
}
