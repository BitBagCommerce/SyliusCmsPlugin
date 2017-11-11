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
        When I go to the create new section page
        And I fill the code with "blog"
        And I fill the name with "Blog"
        And I add it
        Then I should be notified that new section has been created