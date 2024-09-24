@managing_media
Feature: Adding new media
    In order to present more sophisticated content
    As an Administrator
    I want to be able to add new CMS media to the store

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui @javascript
    Scenario: Adding new media
        When I go to the create media page
        And I fill the code with "image"
        And I fill the name with "Image"
        And I upload the "aston_martin_db_11.jpg" image
        And I add it
        Then I should be notified that new media has been created

    @ui
    Scenario: Trying to add a media with an existing code
        Given there is an existing media with "image" code
        When I go to the create media page
        And I fill the code with "image"
        And I try to add it
        Then I should be notified that there is already an existing media with provided code

    @ui
    Scenario: Trying to add media with blank data
        When I go to the create media page
        And I try to add it
        Then I should be notified that "Code, File" fields cannot be blank

    @ui
    Scenario: Trying to add media with too short data
        When I go to the create media page
        And I fill "Code, Name" fields with 1 character
        And I try to add it
        Then I should be notified that "Code, Name" fields are too short

    @ui
    Scenario: Trying to add media with too long data
        When I go to the create media page
        And I fill "Code, Name" fields with 251 characters
        And I try to add it
        Then I should be notified that "Code, Name" fields are too long
