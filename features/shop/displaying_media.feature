@shop_media
Feature: Displaying media

  Background:
    Given the store operates on a single channel in "United States"
    And there is an existing media with "media-1" code
    And there is an existing "image" media with "image-1" code

  @ui
  Scenario: Displaying media
    When I go to the homepage
    And I want to see a media