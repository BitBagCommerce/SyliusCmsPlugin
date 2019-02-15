@managing_sections
Feature: Adding new section
    In order to present more sophisticated content
    As an Administrator
    I want to be able to add new CMS sections to the store

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Adding new section
        When I go to the create section page
        And I fill the code with "blog"
        And I fill the name with "Blog"
        And I add it
        Then I should be notified that new section has been created

    @ui
    Scenario: Trying to add a section with an existing code
        Given there is an existing section with "blog" code
        When I go to the create section page
        And I fill the code with "blog"
        And I try to add it
        Then I should be notified that there is already an existing section with provided code

    @ui
    Scenario: Trying to add section with blank data
        When I go to the create section page
        And I try to add it
        Then I should be notified that "Code, Name" fields cannot be blank

    @ui
    Scenario: Trying to add section with too short data
        When I go to the create section page
        And I fill "Code, Name" fields with 1 character
        And I try to add it
        Then I should be notified that "Code, Name" fields are too short

    @ui
    Scenario: Trying to add section with too long data
        When I go to the create section page
        And I fill "Code, Name" fields with 251 characters
        And I try to add it
        Then I should be notified that "Code, Name" fields are too long
