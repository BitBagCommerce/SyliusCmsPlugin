@wysiwyg @managing_pages
Feature: Managing dynamic content on block page
    As an Administrator
    I want to be able to use the Trix WYSIWYG editor

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui @javascript
    Scenario: Adding page
        When I go to the create page page
        Then I should see the Trix WYSIWYG editor initialized

    @ui @javascript
    Scenario: Updating page
        Given there is an existing page with "test_page" code
        When I go to the update "test_page" page page
        Then I should see the Trix WYSIWYG editor initialized

