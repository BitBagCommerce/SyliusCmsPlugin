@managing_pages
Feature: Managing cms pages
    In order to present custom pages in my online store
    As an Administrator
    I want to be able to display and remove existing pages.

    Background:
        Given the store operates on a single channel in "United States"
        Given I am logged in as an administrator

    @ui
    Scenario: Removing single page
        Given there are 3 pages
        When I go to the cms pages page
        And I remove last page
        Then I should be notified that this page was removed
        And 2 pages should exist in the store