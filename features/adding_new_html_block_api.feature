@managing_blocks
Feature: Adding image block
    In order to manage dynamic text content
    As an API user
    I want to be able to add new text blocks

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @api
    Scenario: Shows all blocks
        When I make a "GET" request to "/api/blocks/"
        Then the response status code should be 200
