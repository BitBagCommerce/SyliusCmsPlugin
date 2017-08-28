@managing_blocks
Feature: Updating image block
    In order to manage dynamic images
    As an Administrator
    I want to be able to edit existing image blocks

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator
        And there is a cms block with "porsche_911_singer" code and "porsche_911_singer_1.jpg" image

    @ui
    Scenario: Seeing menu items
        When I go to the update "porsche_911_singer" block page
        And I upload the "porsche_911_singer_2.jpg" image
        And I update it
        Then I should be notified that the block was successfully updated
        And image block with "porsche_911_singer" code and "porsche_911_singer_2.jpg" image should exist in the store
