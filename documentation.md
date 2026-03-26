# Backend Integration Documentation

## Overview

This project uses a PHP web frontend with a separate backend API. The web pages were built to follow the same logic already used in the React Native app.

Backend base URL is configured through `.env`:

- `API=http://localhost:5000`
- `APP_URL=http://localhost/nng`

Shared bootstrapping is handled through:

- `bootstrap.php`
- `config/env.php`
- `config/app.php`
- `helpers/api.php`
- `helpers/auth.php`

## Shared Backend Configuration

### Environment

The web app reads backend and app settings from `.env`.

Important keys:

- `APP_NAME`
- `APP_URL`
- `API`
- `API_TIMEOUT`

### URL Helpers

Shared URL helpers were added in `config/app.php`:

- `config()`
- `app_url()`
- `asset_url()`

These are used so all internal links and asset paths resolve correctly from the app base URL.

### API Requests

Backend communication is centralized through `helpers/api.php`.

The PHP pages call the backend API instead of duplicating business logic locally.

## Authentication and Session Handling

### Login Flow

The web login page posts credentials to:

- `api/auth/login`

On success, the backend returns a flat user object plus token:

- `id`
- `name`
- `username`
- `email`
- `cm_no`
- `role`
- `status`
- `can_book`
- `fees_status`
- `token`

The PHP app stores this in session through:

- `extract_auth_token()`
- `extract_auth_user()`
- `login_user()`

### Important Fix

The backend login response is flat, not nested under `user`.

`helpers/auth.php` was fixed so session storage now correctly preserves:

- `role`
- `id`
- `cm_no`
- `status`
- `can_book`
- `fees_status`

This fixed the issue where admin users were being treated as normal members in the web app.

### Session/Auth Helpers

Shared auth helpers in `helpers/auth.php` include:

- `is_logged_in()`
- `auth_user()`
- `auth_token()`
- `login_user()`
- `logout_user()`
- `redirect()`
- `require_auth()`
- `auth_is_admin()`
- `require_admin()`
- `auth_user_name()`
- `auth_user_email()`
- `auth_user_role()`
- `auth_user_initial()`
- `extract_auth_token()`
- `extract_auth_user()`
- `extract_api_error_message()`

### Admin Role Access

Admin access is based on the `role` column from the `users` table.

Accepted admin roles:

- `admin`
- `superadmin`

Protected admin pages use:

- `require_admin()`

Regular protected pages use:

- `require_auth()`

## Unauthorized Access Rules

### Not Logged In

If a user is not logged in and tries to access protected pages, they are redirected to:

- `unauthorized.php`

This applies to pages like:

- `dashboard`
- `court_form`
- `event_form`
- `court_history`
- `event_history`
- `profile`
- `admin_panel`
- `manage_users`
- `manage_court`
- `manage_event`

### Logged In But Not Admin

If a normal logged-in user tries to access:

- `admin_panel`
- `manage_users`
- `manage_court`
- `manage_event`

they are also redirected to:

- `unauthorized.php`

## Backend APIs Connected to Web Pages

### Auth APIs

Used endpoints:

- `api/auth/login`
- `api/auth/register`
- `api/auth/me`

### Court Booking APIs

Used endpoints:

- `api/courts`
- `api/users/booking-options`
- `api/bookings`
- `api/bookings/my`

Features implemented on web:

- load courts
- load available players
- load bookings by court and date
- create booking
- view own court booking history

### Event Booking APIs

Used endpoints:

- `api/events`
- `api/event-bookings`
- `api/event-bookings/my`

Features implemented on web:

- load events/venues
- load booked slots by event and date
- create event booking
- view own event booking history

### User Management APIs

Used endpoints:

- `api/users`
- `api/users/{id}`

Features implemented on web:

- list users
- search users
- create user
- update user
- delete user
- paginate records on the web page

### Court Management APIs

Used endpoints:

- `api/courts`
- `api/courts/{id}`

Features implemented on web:

- list courts
- search courts
- create court
- update court
- delete court
- upload court image

### Event Management APIs

Used endpoints:

- `api/events`
- `api/events/{id}`

Features implemented on web:

- list events/venues
- search events
- create event
- update event
- delete event
- upload event image

## Web Pages Created or Connected to Backend

### User Pages

- `login.php`
- `register.php`
- `dashboard.php`
- `profile.php`
- `court_form.php`
- `court_history.php`
- `event_form.php`
- `event_history.php`
- `unauthorized.php`

### Admin Pages

- `admin_panel.php`
- `manage_users.php`
- `manage_court.php`
- `manage_event.php`

## AJAX Pattern Used in PHP Pages

Several PHP pages act as both:

- page renderer
- AJAX bridge to backend

Common pattern:

- page loads normally
- frontend JS calls same page with `?ajax=...`
- PHP handler forwards the request to backend API
- JSON is returned to the browser

This was used to keep the web pages simple and avoid CORS/session problems.

## File Upload Handling

For admin CRUD pages with images:

- `manage_court.php`
- `manage_event.php`

multipart upload forwarding was implemented using PHP cURL with `CURLFile`.

This allows image uploads to be sent from the web admin page to the backend API.

## Link and Redirect Fixes

Shared link and redirect handling was fixed so the app no longer generates broken URLs like:

- `http://localhost/C:/xampp/htdocs/...`

This was solved by:

- improving `app_url()` in `config/app.php`
- updating `redirect()` in `helpers/auth.php`
- switching pages to use shared helpers for internal links

## Registration Support

The PHP `register.php` page was aligned with the backend/mobile behavior:

- validates name, username, email, password
- username format check
- minimum password length
- submits to `api/auth/register`
- shows backend success/error response
- redirects to login after successful registration

## Notes

- The web app does not reimplement backend business rules.
- Booking availability, auth, role handling, and data persistence all remain in the backend API.
- The PHP layer mainly handles UI, session storage, and API integration.
