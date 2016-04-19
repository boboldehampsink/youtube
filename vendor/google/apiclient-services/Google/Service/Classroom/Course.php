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

class Google_Service_Classroom_Course extends Google_Model
{
  public $alternateLink;
  public $courseState;
  public $creationTime;
  public $description;
  public $descriptionHeading;
  public $enrollmentCode;
  public $id;
  public $name;
  public $ownerId;
  public $room;
  public $section;
  public $updateTime;

  public function setAlternateLink($alternateLink)
  {
    $this->alternateLink = $alternateLink;
  }
  public function getAlternateLink()
  {
    return $this->alternateLink;
  }
  public function setCourseState($courseState)
  {
    $this->courseState = $courseState;
  }
  public function getCourseState()
  {
    return $this->courseState;
  }
  public function setCreationTime($creationTime)
  {
    $this->creationTime = $creationTime;
  }
  public function getCreationTime()
  {
    return $this->creationTime;
  }
  public function setDescription($description)
  {
    $this->description = $description;
  }
  public function getDescription()
  {
    return $this->description;
  }
  public function setDescriptionHeading($descriptionHeading)
  {
    $this->descriptionHeading = $descriptionHeading;
  }
  public function getDescriptionHeading()
  {
    return $this->descriptionHeading;
  }
  public function setEnrollmentCode($enrollmentCode)
  {
    $this->enrollmentCode = $enrollmentCode;
  }
  public function getEnrollmentCode()
  {
    return $this->enrollmentCode;
  }
  public function setId($id)
  {
    $this->id = $id;
  }
  public function getId()
  {
    return $this->id;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setOwnerId($ownerId)
  {
    $this->ownerId = $ownerId;
  }
  public function getOwnerId()
  {
    return $this->ownerId;
  }
  public function setRoom($room)
  {
    $this->room = $room;
  }
  public function getRoom()
  {
    return $this->room;
  }
  public function setSection($section)
  {
    $this->section = $section;
  }
  public function getSection()
  {
    return $this->section;
  }
  public function setUpdateTime($updateTime)
  {
    $this->updateTime = $updateTime;
  }
  public function getUpdateTime()
  {
    return $this->updateTime;
  }
}
