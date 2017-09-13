@managing_blocks
Feature: Adding image block
    In order to manage dynamic text content
    As an Administrator
    I want to be able to add new text blocks

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui
    Scenario: Seeing menu items
        When I go to the create "html" block page
        And I fill the code with "store_description"
        And I fill the content with "<p>We have the best candies in the internet!</p>"
        And I add it
        Then I should be notified that new text block was created
        And block with "html" type and "<p>We have the best candies in the internet!</p>" content should exist in the store