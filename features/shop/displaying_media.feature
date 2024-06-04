@shop_media
Feature: Displaying media

  Background:
    Given the store operates on a single channel in "United States"

  @ui
  Scenario: Displaying media
    And there is an existing "image" media with "homepage_pdf" code
    When I go to the homepage
    And I want to see a media with code "homepage_pdf"

  @ui
  Scenario: Displaying media no standard template
    And there is an existing "image" media with "media_with_parameters" code
    When I go to the homepage
    And I want to see a media with code "media_with_parameters"
