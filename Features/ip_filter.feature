Feature: A server restrict access on resources
  A server want to restrict access on resource
  It stores IP addesses or ranges of IP addresses and
  Depending on the request received, grant or denied access on the resource

  Scenario: I want to access on a resource, but my IP is denied
    Given my IP address is '192.168.1.20'
    When I "GET" the request to "https://local.dev/"
    Then I should be denied

  Scenario: I want to access on a resource and my IP is authorized
    Given my IP address is 'fe80::2:0'
    When I "GET" the request to "https://local.dev/"
    Then I should be granted
    And I should see "Hello world!"

  Scenario: I want to access on a resource and my IP is authorized
    Given my IP address is '192.168.1.12'
    When I "GET" the request to "https://local.dev/"
    Then I should be granted
    And I should see "Hello world!"

  Scenario: I want to access on a resource and my IP is authorized
    Given my IP address is '192.168.1.22'
    When I "GET" the request to "https://local.dev/"
    Then I should be granted
    And I should see "Hello world!"
