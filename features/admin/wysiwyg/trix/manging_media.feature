@wysiwyg @managing_media
Feature: Managing dynamic content on media page
    As an Administrator
    I want to be able to use the Trix WYSIWYG editor

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui @javascript
    Scenario: Adding media
        When I go to the create media page
        Then I should see the Trix WYSIWYG editor initialized
