@managing_blocks
Feature: Adding image block
    In order to manage dynamic text content
    As an Administrator
    I want to be able to disable existing blocks

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"
        And there is a cms text block with "bitbag_quote" code and "We develop eCommerce. With pleasure" content

    @ui
    Scenario: Seeing menu items
        When I go to the update "bitbag_quote" block page
        And I disable it
        And I update it
        Then block with "bitbag_quote" should not appear in the store