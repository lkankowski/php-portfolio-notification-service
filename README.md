# Notification Service

## Pre-Requirements
* Linux (tested on Ubuntu 22.04.1 LTS)
* PHP 8.1
* Composer
* Docker (with Compose v2)


## Setup
Sample data in `.env.local`:
```ini
PUSHY_URL=https://api.pushy.me
PUSHY_API_KEY=[PASTE YOUR SECRET API KEY HERE]

MAILER_DSN=mailgun://[API_KEY]:[DOMAIN]@default?region=us
MAILER_SENDER='Test user <mailgun@[DOMAIN]>'
MAILER_SUBJECT='Test subject'
```


## Install
```shell
composer install
#bin/console doctrine:database:create
bin/console doctrine:migrations:migrate
```
or single command
```shell
TODO
```
and go to http://127.0.0.1:8082/ in browser.


## Functional requirements
Create a service that accepts the necessary information and sends a notification to customers.
It should provide an abstraction between at least two different messaging service providers.

It can use different messaging services/technologies for communication (e.g. SMS, email,
push notification, Facebook Messenger etc).

If one of the services goes down, your service can quickly failover to a different provider
without affecting your customers.

Example messaging providers:
* [x] Emails: AWS SES (https://docs.aws.amazon.com/ses/latest/APIReference/API_SendEmail.html)
  * Mailgun
* [ ] SMS messages: Twilio (https://www.twilio.com/docs/sms/api)
* [x] Push notifications: Pushy (https://pushy.me/docs/api/send-notifications)

All listed services are free to try and are pretty painless to sign up for, so please register
your own test accounts on each.

Here is what we want to see in the service:
* [x] Multi-channel: service can send messages via the multiple channels, with a fail-over
* [x] Configuration-driven: It is possible to enable / disable different communication channels with configuration.
* [x] (Bonus point) Localisation: service supports localised messages, in order for the customer
to receive communication in their preferred language.
* [ ] (Bonus point) Usage tracking: we can track what messages were sent, when and to whom.


## Providers

### Mailgun
With trial account you can send emails only to authorized recipients - by default account owner.

## TO IMPROVE
* [ ] more abstraction over recipient data currently stored directly in `NotificationFormData`
* [ ] use SMTP instead of direct integration and use MailHog/MailCatcher for development
* [ ] functional test with Codeception?
* [ ] use Make for task automation (run tests and static analysis)
* [ ] move ORM attributes to XML
* [ ] `bin/console doctrine:migrations:migrate` into docker entrypoint
* [ ] docker multi-stage build (separate xdebug?)
* [ ] CSRF
* [ ] move out entities/EM from controllers (currently done only in `ChannelsController`)
