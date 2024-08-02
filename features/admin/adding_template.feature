@managing_templates
Feature: Adding cms templates
    In order to create templates
    As an Administrator
    I want to be able to add new templates

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Creating template
        When I go to the create template page
        And I fill the name with "Test template"
        And I choose "Page" in Type field
        And I add it
        Then I should be notified that the template has been created

    @ui @javascript
    Scenario: Creating template with content elements
        When I go to the create template page
        And I fill the name with "Test template"
        And I choose "Page" in Type field
        And I click on Add button in Content elements section
        And I select "Textarea" content element
        And I click on Add button in Content elements section
        And I select "Single media" content element
        And I add it
        Then I should be notified that the template has been created
        And I should see newly created "Textarea" content element in Content elements section
        And I should see newly created "Single media" content element in Content elements section

    @ui
    Scenario: Trying to add template with existing name
        Given there is a template in the store with "New template" name
        When I go to the create template page
        And I fill the name with "New template"
        And I try to add it
        Then I should be notified that there is already existing template with provided name

    @ui
    Scenario: Adding new template with blank data
        When I go to the create template page
        And I add it
        And I should be notified that "Name" field cannot be blank

    @ui
    Scenario: Trying to add a template with too short data
        When I go to the create template page
        And I fill the name with "X"
        And I try to add it
        Then I should be notified that "Name" field is too short

    @ui
    Scenario: Trying to add a template with too long data
        When I go to the create template page
        And I fill "Name" field with 251 characters
        And I try to add it
        Then I should be notified that "Name" field is too long
