@shop_blocks
Feature: Getting data from cms blocks
    In order to present dynamic content in my store
    As an API user
    I want to be able to display blocks

    Background:
        Given the store operates on a single channel in "United States"
        And there is a block in the store
        And there is a block with "block-1" code and "Hi there!" content

    @api
    Scenario: Browsing blocks
        Given I want to browse blocks
        Then I should see 2 blocks in the list
        And I should see block with code "block-1"

    @api
    Scenario: Displaying block
        Given I view block with code "block-1"
        Then I should see block name
        And I should see block content

