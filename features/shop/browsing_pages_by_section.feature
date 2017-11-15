@shop_pages
Feature: Browsing pages by section
    In order to read content like articles or blog posts
    As a Customer
    I want to browse pages by specific sections

    Background:
        Given the store operates on a single channel in "United States"

    @ui
    Scenario: Browsing pages by section
        Given there is a "Blog" section in the store
        And there are 15 pages in the store
        And these pages have this section associated with it
        When I go to the section pages list for the "blog" section
        Then I should see 10 pages on the page