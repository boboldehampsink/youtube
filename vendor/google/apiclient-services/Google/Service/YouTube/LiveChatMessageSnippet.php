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

class Google_Service_YouTube_LiveChatMessageSnippet extends Google_Model
{
  public $authorChannelId;
  public $displayMessage;
  protected $fanFundingEventDetailsType = 'Google_Service_YouTube_LiveChatFanFundingEventDetails';
  protected $fanFundingEventDetailsDataType = '';
  public $hasDisplayContent;
  public $liveChatId;
  public $publishedAt;
  protected $textMessageDetailsType = 'Google_Service_YouTube_LiveChatTextMessageDetails';
  protected $textMessageDetailsDataType = '';
  public $type;

  public function setAuthorChannelId($authorChannelId)
  {
    $this->authorChannelId = $authorChannelId;
  }
  public function getAuthorChannelId()
  {
    return $this->authorChannelId;
  }
  public function setDisplayMessage($displayMessage)
  {
    $this->displayMessage = $displayMessage;
  }
  public function getDisplayMessage()
  {
    return $this->displayMessage;
  }
  public function setFanFundingEventDetails(Google_Service_YouTube_LiveChatFanFundingEventDetails $fanFundingEventDetails)
  {
    $this->fanFundingEventDetails = $fanFundingEventDetails;
  }
  public function getFanFundingEventDetails()
  {
    return $this->fanFundingEventDetails;
  }
  public function setHasDisplayContent($hasDisplayContent)
  {
    $this->hasDisplayContent = $hasDisplayContent;
  }
  public function getHasDisplayContent()
  {
    return $this->hasDisplayContent;
  }
  public function setLiveChatId($liveChatId)
  {
    $this->liveChatId = $liveChatId;
  }
  public function getLiveChatId()
  {
    return $this->liveChatId;
  }
  public function setPublishedAt($publishedAt)
  {
    $this->publishedAt = $publishedAt;
  }
  public function getPublishedAt()
  {
    return $this->publishedAt;
  }
  public function setTextMessageDetails(Google_Service_YouTube_LiveChatTextMessageDetails $textMessageDetails)
  {
    $this->textMessageDetails = $textMessageDetails;
  }
  public function getTextMessageDetails()
  {
    return $this->textMessageDetails;
  }
  public function setType($type)
  {
    $this->type = $type;
  }
  public function getType()
  {
    return $this->type;
  }
}
