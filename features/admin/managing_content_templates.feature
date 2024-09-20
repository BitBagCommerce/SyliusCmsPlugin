@managing_content_templates
Feature: Managing cms templates
    In order to manage existing templates
    As an Administrator
    I want to be able to edit and remove existing templates

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Deleting template
        Given there is a template in the store with "Test template" name
        When I go to the templates page
        And I delete this template
        Then I should be notified that the template has been deleted
        And I should see empty list of templates

    @ui
    Scenario: Updating template
        Given there is a template in the store with "Test template" name
        When I go to the update "Test template" template page
        And I fill the name with "New template"
        And I update it
        Then I should be notified that the template has been successfully updated

    @ui @javascript
    Scenario: Updating template with content elements
        Given there is a template in the store with "Test template" name
        And there are "Textarea" and "Single media" content elements in this template
        When I go to the update "Test template" template page
        And I delete "Textarea" content element
        And I update it
        Then I should be notified that the template has been successfully updated
        And I should see only "Single media" content element in Content elements section
