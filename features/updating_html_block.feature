@managing_blocks
Feature: Updating image block
    In order to manage dynamic images
    As an Administrator
    I want to be able to edit existing image blocks

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator
        And there is a cms html block with "store_email" code and "<a href='mailto:mikolaj.krol@bitbag.pl'>mikolaj.krol@bitbag.pl</a>" content

    @ui
    Scenario: Seeing menu items
        When I go to the update "store_email" block page
        And I fill the content with "<a href='mailto:mikolaj.krol@bitbag.pl'>mikolaj.krol@bitbag.pl</a>"
        And I update it
        Then I should be notified that the block was successfully updated
        And block with "store_email" code and "<a href='mailto:mikolaj.krol@bitbag.pl'>mikolaj.krol@bitbag.pl</a>" content should exist in the store