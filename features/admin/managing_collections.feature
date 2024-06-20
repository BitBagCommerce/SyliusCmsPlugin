@managing_collections
Feature: Managing collections
    In order to present the content in specific collections in my store
    As an Administrator
    I want to be able to edit and remove existing collections

    Background:
        Given the store operates on a single channel in "United States"
        Given I am logged in as an administrator

    @ui
    Scenario: Deleting collection
        Given there is a collection in the store
        When I go to the collections page
        And I delete this collection
        Then I should be notified that the collection has been deleted
        And I should see empty list of collections

    @ui
    Scenario: Seeing disabled code field while editing a collection
        Given there is a collection in the store
        When I want to edit this collection
        Then the code field should be disabled
