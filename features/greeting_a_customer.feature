@greeting_customer
Feature: Greeting a customer
    In order to provide an ultimate customer experience
    As a Store Owner
    I want to welcome new customers

    Scenario: Greeting a customer with an unknown name
        When a customer with an unknown name visits welcome page
        Then they should be greeted with "Hello!"

    Scenario: Greeting a customer with a known name
        When a customer named "Krzysztof" visits welcome page
        Then they should be greeted with "Hello, Krzysztof!"
