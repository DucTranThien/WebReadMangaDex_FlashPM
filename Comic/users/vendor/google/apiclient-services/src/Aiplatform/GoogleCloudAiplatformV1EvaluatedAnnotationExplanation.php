<?php
/*
 * Copyright 2014 Google Inc.
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

namespace Google\Service\Aiplatform;

class GoogleCloudAiplatformV1EvaluatedAnnotationExplanation extends \Google\Model
{
  protected $explanationDataType = '';
  /**
   * @var string
   */
  public $explanationType;

  /**
   * @param GoogleCloudAiplatformV1Explanation
   */
  public function setExplanation(GoogleCloudAiplatformV1Explanation $explanation)
  {
    $this->explanation = $explanation;
  }
  /**
   * @return GoogleCloudAiplatformV1Explanation
   */
  public function getExplanation()
  {
    return $this->explanation;
  }
  /**
   * @param string
   */
  public function setExplanationType($explanationType)
  {
    $this->explanationType = $explanationType;
  }
  /**
   * @return string
   */
  public function getExplanationType()
  {
    return $this->explanationType;
  }
}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(GoogleCloudAiplatformV1EvaluatedAnnotationExplanation::class, 'Google_Service_Aiplatform_GoogleCloudAiplatformV1EvaluatedAnnotationExplanation');
