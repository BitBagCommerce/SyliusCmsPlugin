@managing_sections
Feature: Managing sections
    In order to present the content in specific sections in my store
    As an Administrator
    I want to be able to edit and remove existing sections

    Background:
        Given the store operates on a single channel in "United States"
        Given I am logged in as an administrator

    @ui
    Scenario: Deleting section
        Given there is a section in the store
        When I go to the sections page
        And I delete this section
        Then I should be notified that the section has been deleted
        And I should see empty list of sections

    @ui
    Scenario: Seeing disabled code field while editing a section
        Given there is a section in the store
        When I want to edit this section
        Then the code field should be disabled
