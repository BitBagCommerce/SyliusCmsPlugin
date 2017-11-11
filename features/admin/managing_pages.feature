@managing_pages
Feature: Managing cms pages
    In order to present custom pages in my online store
    As an Administrator
    I want to be able to display and remove existing pages

    Background:
        Given the store operates on a single channel in "United States"
        Given I am logged in as an administrator

    @ui
    Scenario: Removing single page
        Given there are 3 pages
        When I go to the cms pages page
        And I remove last page
        Then I should be notified that this page has been removed
        And only 2 pages should exist in the store

    @ui
    Scenario: Updating page
        Given there is a cms page with "How to tie a tie" name
        And it has "tie a tie, 100 ways to tie a tie" meta keywords
        And it has "After reading this tut you will never get stuck while trying to tie a tie." meta description
        And it has "Learn how to tie a tie with the Windsor, Half Windsor, Four in Hand and Pratt necktie knots by following step-by-step video." content
        When I go to the update "how_to_tie_a_tie" page page
        And I fill the name with "Top 5 outfits for this summer"
        And I fill the slug with "top-5-outfits-for-this-summer"
        And I fill the meta keywords with "TOP 5 summer outfit trends, outfits, ralph lauren"
        And I fill the meta description with "This summer is going to be hot. Here's what you must wear to look great on vacation."
        And I fill the content with "The best looks, trends, inspiration, and shopping picks for summer style."
        And I update it
        Then I should be notified that the page was updated