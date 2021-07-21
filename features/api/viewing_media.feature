@shop_media
Feature: Getting data from cms media
    In order to present dynamic content in my store
    As an API user
    I want to be able to display media files

    Background:
        Given the store operates on a single channel in "United States"
        And there is an existing media with "media-1" code
        And there is an existing "image" media with "image-1" code

    @api
    Scenario: Browsing media
        Given I want to browse media
        Then I should see 2 media in the list
        And I should see media with code "media-1"

    @api
    Scenario: Displaying media
        Given I view media with code "image-1"
        Then I should see media name
