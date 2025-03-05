@wysiwyg @managing_blocks
Feature: Managing dynamic content on block page
    As an Administrator
    I want to be able to use the Trix WYSIWYG editor

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui @javascript
    Scenario: Adding block
        When I go to the create block page
        Then I should see the Trix WYSIWYG editor initialized

    @ui @javascript
    Scenario: Updating block
        Given there is a block with "content" code and "<p>Content !</p>" content
        When I go to the update "content" block page
        Then I should see the Trix WYSIWYG editor initialized

