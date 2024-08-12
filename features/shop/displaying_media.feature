@shop_media
Feature: Displaying media

  Background:
    Given the store operates on a single channel in "United States"

  @ui
  Scenario: Displaying media
    And there is an existing "image" media with "blog_banner" code
    When I go to the "blog" page
    And I want to see a media with code "blog_banner"
