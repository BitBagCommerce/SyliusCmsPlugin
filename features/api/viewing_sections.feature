@shop_sections
Feature: Getting data from cms sections
    In order to present dynamic content in my store
    As an API user
    I want to be able to display sections

    Background:
        Given the store operates on a single channel in "United States"
        And there is a section in the store
        And there is an existing section with "section-1" code

    @api
    Scenario: Browsing sections
        Given I want to browse sections
        Then I should see 2 sections in the list
        And I should see section with code "section-1"

    @api
    Scenario: Display section
        Given I view section with code "section-1"
        Then I should see section name
