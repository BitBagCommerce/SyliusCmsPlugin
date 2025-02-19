@managing_trix_wysiwyg
Feature: Managing dynamic content on store pages
    In order to present and manage dynamic content on my store pages
    As an Administrator
    I want to be able to use the Trix WYSIWYG editor

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @managing_blocks @ui @javascript
    Scenario: Adding block
        When I go to the create block page
        Then I should see the Trix WYSIWYG editor initialized
#
#    @managing_sections @ui @javascript
#    Scenario: Adding section
#        When I go to the create section page
#        Then I should see the Trix WYSIWYG editor initialized
#
#    @managing_pages @ui @javascript
#    Scenario: Adding page
#        When I go to the create page page
#        Then I should see the Trix WYSIWYG editor initialized
#
#    @managing_media @ui @javascript
#    Scenario: Adding media
#        When I go to the create media page
#        Then I should see the Trix WYSIWYG editor initialized
