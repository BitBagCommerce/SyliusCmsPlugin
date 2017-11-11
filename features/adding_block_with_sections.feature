@managing_blocks
Feature: Adding block with sections
    In order to display blocks under some sections
    As an Administrator
    I want to be able to add new blocks with existing sections

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @javascript
    Scenario: Seeing menu items
        Given there is are existing sections named "Blog" and "Homepage"
        When I go to the create "html" block page
        And I fill the code with "store_description"
        And I fill the content with "<p>We have the best candies in the internet!</p>"
        And I add "Blog" and "Homepage" sections to it
        And I add it
        Then I should be notified that new text block was created