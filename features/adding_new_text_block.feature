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
        When I go to the create "text" block page
        And I fill the code with "store_main_title"
        And I fill the name with "Store title"
        And I fill the content with "Welcome to the Candy Shop"
        And I add it
        Then I should be notified that new text block was created
        And block with "text" type and "Welcome to the Candy Shop" content should exist in the store
        And this block should also have "Store title" name