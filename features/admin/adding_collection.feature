@managing_collections
Feature: Adding new collection
    In order to present more sophisticated content
    As an Administrator
    I want to be able to add new CMS collections to the store

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Adding new collection
        When I go to the create collection page
        And I fill the code with "blog"
        And I fill the name with "Blog"
        And I add it
        Then I should be notified that new collection has been created

    @ui
    Scenario: Trying to add a collection with an existing code
        Given there is an existing collection with "blog" code
        When I go to the create collection page
        And I fill the code with "blog"
        And I try to add it
        Then I should be notified that there is already an existing collection with provided code

    @ui
    Scenario: Trying to add collection with blank data
        When I go to the create collection page
        And I try to add it
        Then I should be notified that "Code, Name" fields cannot be blank

    @ui
    Scenario: Trying to add collection with too short data
        When I go to the create collection page
        And I fill "Code, Name" fields with 1 character
        And I try to add it
        Then I should be notified that "Code, Name" fields are too short

    @ui
    Scenario: Trying to add collection with too long data
        When I go to the create collection page
        And I fill "Code, Name" fields with 251 characters
        And I try to add it
        Then I should be notified that "Code, Name" fields are too long
