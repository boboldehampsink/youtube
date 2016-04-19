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
 * Service definition for Classroom (v1).
 *
 * <p>
 * Google Classroom API</p>
 *
 * <p>
 * For more information about this service, see the API
 * <a href="https://developers.google.com/classroom/" target="_blank">Documentation</a>
 * </p>
 *
 * @author Google, Inc.
 */
class Google_Service_Classroom extends Google_Service
{
  /** Manage your Google Classroom classes. */
  const CLASSROOM_COURSES =
      "https://www.googleapis.com/auth/classroom.courses";
  /** View your Google Classroom classes. */
  const CLASSROOM_COURSES_READONLY =
      "https://www.googleapis.com/auth/classroom.courses.readonly";
  /** View the email addresses of people in your classes. */
  const CLASSROOM_PROFILE_EMAILS =
      "https://www.googleapis.com/auth/classroom.profile.emails";
  /** View the profile photos of people in your classes. */
  const CLASSROOM_PROFILE_PHOTOS =
      "https://www.googleapis.com/auth/classroom.profile.photos";
  /** Manage your Google Classroom class rosters. */
  const CLASSROOM_ROSTERS =
      "https://www.googleapis.com/auth/classroom.rosters";
  /** View your Google Classroom class rosters. */
  const CLASSROOM_ROSTERS_READONLY =
      "https://www.googleapis.com/auth/classroom.rosters.readonly";

  public $courses;
  public $courses_aliases;
  public $courses_students;
  public $courses_teachers;
  public $invitations;
  public $userProfiles;
  
  /**
   * Constructs the internal representation of the Classroom service.
   *
   * @param Google_Client $client
   */
  public function __construct(Google_Client $client)
  {
    parent::__construct($client);
    $this->rootUrl = 'https://classroom.googleapis.com/';
    $this->servicePath = '';
    $this->version = 'v1';
    $this->serviceName = 'classroom';

    $this->courses = new Google_Service_Classroom_CoursesResource(
        $this,
        $this->serviceName,
        'courses',
        array(
          'methods' => array(
            'create' => array(
              'path' => 'v1/courses',
              'httpMethod' => 'POST',
              'parameters' => array(),
            ),'delete' => array(
              'path' => 'v1/courses/{id}',
              'httpMethod' => 'DELETE',
              'parameters' => array(
                'id' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'get' => array(
              'path' => 'v1/courses/{id}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'id' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1/courses',
              'httpMethod' => 'GET',
              'parameters' => array(
                'studentId' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'teacherId' => array(
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
              ),
            ),'patch' => array(
              'path' => 'v1/courses/{id}',
              'httpMethod' => 'PATCH',
              'parameters' => array(
                'id' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'updateMask' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'update' => array(
              'path' => 'v1/courses/{id}',
              'httpMethod' => 'PUT',
              'parameters' => array(
                'id' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
    $this->courses_aliases = new Google_Service_Classroom_CoursesAliasesResource(
        $this,
        $this->serviceName,
        'aliases',
        array(
          'methods' => array(
            'create' => array(
              'path' => 'v1/courses/{courseId}/aliases',
              'httpMethod' => 'POST',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'delete' => array(
              'path' => 'v1/courses/{courseId}/aliases/{alias}',
              'httpMethod' => 'DELETE',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'alias' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1/courses/{courseId}/aliases',
              'httpMethod' => 'GET',
              'parameters' => array(
                'courseId' => array(
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
              ),
            ),
          )
        )
    );
    $this->courses_students = new Google_Service_Classroom_CoursesStudentsResource(
        $this,
        $this->serviceName,
        'students',
        array(
          'methods' => array(
            'create' => array(
              'path' => 'v1/courses/{courseId}/students',
              'httpMethod' => 'POST',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'enrollmentCode' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
              ),
            ),'delete' => array(
              'path' => 'v1/courses/{courseId}/students/{userId}',
              'httpMethod' => 'DELETE',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'userId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'get' => array(
              'path' => 'v1/courses/{courseId}/students/{userId}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'userId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1/courses/{courseId}/students',
              'httpMethod' => 'GET',
              'parameters' => array(
                'courseId' => array(
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
              ),
            ),
          )
        )
    );
    $this->courses_teachers = new Google_Service_Classroom_CoursesTeachersResource(
        $this,
        $this->serviceName,
        'teachers',
        array(
          'methods' => array(
            'create' => array(
              'path' => 'v1/courses/{courseId}/teachers',
              'httpMethod' => 'POST',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'delete' => array(
              'path' => 'v1/courses/{courseId}/teachers/{userId}',
              'httpMethod' => 'DELETE',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'userId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'get' => array(
              'path' => 'v1/courses/{courseId}/teachers/{userId}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'courseId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
                'userId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1/courses/{courseId}/teachers',
              'httpMethod' => 'GET',
              'parameters' => array(
                'courseId' => array(
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
              ),
            ),
          )
        )
    );
    $this->invitations = new Google_Service_Classroom_InvitationsResource(
        $this,
        $this->serviceName,
        'invitations',
        array(
          'methods' => array(
            'accept' => array(
              'path' => 'v1/invitations/{id}:accept',
              'httpMethod' => 'POST',
              'parameters' => array(
                'id' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'create' => array(
              'path' => 'v1/invitations',
              'httpMethod' => 'POST',
              'parameters' => array(),
            ),'delete' => array(
              'path' => 'v1/invitations/{id}',
              'httpMethod' => 'DELETE',
              'parameters' => array(
                'id' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'get' => array(
              'path' => 'v1/invitations/{id}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'id' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),'list' => array(
              'path' => 'v1/invitations',
              'httpMethod' => 'GET',
              'parameters' => array(
                'userId' => array(
                  'location' => 'query',
                  'type' => 'string',
                ),
                'courseId' => array(
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
              ),
            ),
          )
        )
    );
    $this->userProfiles = new Google_Service_Classroom_UserProfilesResource(
        $this,
        $this->serviceName,
        'userProfiles',
        array(
          'methods' => array(
            'get' => array(
              'path' => 'v1/userProfiles/{userId}',
              'httpMethod' => 'GET',
              'parameters' => array(
                'userId' => array(
                  'location' => 'path',
                  'type' => 'string',
                  'required' => true,
                ),
              ),
            ),
          )
        )
    );
  }
}
