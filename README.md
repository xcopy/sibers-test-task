A small PHP application that fetches and displays data from multiple external sources in a paginated UI.

**Installation**

- Clone the project: `git clone https://github.com/xcopy/sibers-test-task.git xcopy-sibers-test-task`
- Go to the project root
- Install dependencies: `composer install`
- Start a local PHP server:
  - `cd public`
  - `php -S localhost:8000`
- Open the app in your browser: http://localhost:8000

**Caching**

The application stores API responses in a local cache directory under `src/cache/` and keeps each cached response valid for 5 minutes. After the expiration window, the old file is removed and a fresh request is made.
