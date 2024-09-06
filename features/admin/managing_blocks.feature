@managing_blocks
Feature: Managing cms blocks
    In order to present dynamic content in my store
    As an Administrator
    I want to be able to manage existing blocks

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @fail
    Scenario: Deleting block
        Given there is a block in the store
        When I go to the blocks page
        And I delete this block
        Then I should be notified that the block has been deleted
        And I should see empty list of blocks

    @ui @javascript
    Scenario: Updating block
        Given there is a block with "store_phone_number" code
        When I go to the update "store_phone_number" block page
        And I fill the name with "Store phone number" if the name field is empty
        And I update it
        Then I should be notified that the block has been successfully updated

    @ui
    Scenario: Updating block textarea content element
        Given there is a block with "store_phone_number" code and "Textarea" content element
        When I go to the update "store_phone_number" block page
        And I fill the name with "Store phone number" if the name field is empty
        And I change textarea content element value to "New content"
        And I update it
        Then I should be notified that the block has been successfully updated
        And I should see "New content" in the textarea content element

    @ui @javascript
    Scenario: Deleting content element in block
        Given there is a block with "store_phone_number" code and "Textarea" content element
        When I go to the update "store_phone_number" block page
        And I fill the name with "Store phone number" if the name field is empty
        And I delete the content element
        And I update it
        Then I should be notified that the block has been successfully updated
        And I should not see "Textarea" content element in the Content elements section

    @ui
    Scenario: Disabling block
        Given there is an existing block with "sylius_quote" code
        When I go to the update "sylius_quote" block page
        And I fill the name with "BitBag quote" if the name field is empty
        And I disable it
        And I update it
        Then I should be notified that the block has been successfully updated
        And this block should be disabled

    @ui
    Scenario: Seeing disabled code field while editing a block
        Given there is a block in the store
        When I want to edit this block
        Then the code field should be disabled
