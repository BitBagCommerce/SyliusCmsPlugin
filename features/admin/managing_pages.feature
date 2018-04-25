@managing_pages
Feature: Managing cms pages
    In order to present custom pages in my online store
    As an Administrator
    I want to be able to edit and remove existing pages

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Deleting page
        Given there is a page in the store
        When I go to the pages page
        And I delete this page
        Then I should be notified that the page has been deleted
        And I should see empty list of pages

    @ui
    Scenario: Seeing disabled code field while editing a page
        Given there is a page in the store
        When I want to edit this page
        Then the code field should be disabled

    @ui
    Scenario: Updating page
        Given there is a page in the store
        When I want to edit this page
        And I fill "Code, Content" fields
        And I update it
        Then I should be notified that the page was updated

    @ui
    Scenario: Updating page with image
        Given there is a page in the store
        When I want to edit this page
        And I fill "Code, Content" fields
        And I upload the "aston_martin_db_11.jpg" image
        And I update it
        Then I should be notified that the page was updated