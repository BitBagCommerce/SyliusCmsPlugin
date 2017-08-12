@managing_blocks
Feature: Updating image block
    In order to manage dynamic images
    As an Administrator
    I want to be able to edit existing image blocks

    Background:
        Given I am logged in as an administrator
        And there is a cms block with "porsche_911_singer" code and "/cms/block/image/singer_911_1.jpg" content

    @ui
    Scenario: Seeing menu items
        When I go to the update "porsche_911_singer" block page
        And I upload the "singer_911_2.jpg" image
        And I update it
        Then I should be notified that the block was successfully updated
        And block with "image" type and "/cms/block/image/aston_martin_db_11.jpg" content should be in the store