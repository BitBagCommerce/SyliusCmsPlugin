@managing_blocks
Feature: Adding block with sections
    In order to display blocks under some sections
    As an Administrator
    I want to be able to add new blocks with existing sections

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @todo
    Scenario: Seeing menu items
        Given there is are existing sections named "Blog" and "Homepage"
        When I go to the create "image" block page
        And I fill the code with "blog_header_image"
        And I upload the "aston_martin_db_11.jpg" image
        And I add it
        And I add "Blog" and "Homepage" sections to it
        Then I should be notified that new block has been created