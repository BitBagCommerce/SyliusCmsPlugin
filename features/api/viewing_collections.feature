@shop_collections
Feature: Getting data from cms collections
    In order to present dynamic content in my store
    As an API user
    I want to be able to display collections

    Background:
        Given the store operates on a single channel in "United States"
        And there is a collection in the store
        And there is an existing collection with "collection-1" code

    @api
    Scenario: Browsing collections
        Given I want to browse collections
        Then I should see 2 collections in the list
        And I should see collection with code "collection-1"

    @api
    Scenario: Displaying collection
        Given I view collection with code "collection-1"
        Then I should see collection name
