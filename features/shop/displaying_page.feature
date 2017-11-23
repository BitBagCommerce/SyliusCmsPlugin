@shop_pages
Feature: Displaying pages
    In order to read store information
    As a Customer
    I want to display pages

    Background:
        Given the store operates on a single channel in "United States"

    @ui
    Scenario: Displaying page
        Given there is a page in the store
        And the store has "iPhone 8" and "iPhone X" products
        And this page has these products associated with it
        And there are existing sections named "Blog" and "General"
        And this page has these sections associated with it
        And this page has "About us" name
        And this page also has "about-us" slug
        And this page also has "Lorem ipsum" content
        When I go to the "about-us" page
        Then I should see a page with "About us" name
        And I should also see "Lorem ipsum" content
        And I should also see "iPhone 8" and "iPhone X" products associated with this page
        And I should also see "Blog" and "General" sections associated with this page

    @ui
    Scenario: Displaying page link
        Given there is a page in the store
        And this page has "about" code
        And this page has "About" name
        When I go to this page
        Then I should see the "About" page link in the header
