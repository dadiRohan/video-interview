# Video Interview (Laravel + MySQL)

## What it is
A minimal one-way video interview app:
- Admin/Reviewer create interviews with questions
- Candidate records answers in browser and uploads video
- Reviewer views submissions and leaves score+comment

## Setup (local)
1. Clone repo
2. `composer install`
3. `cp .env.example .env` and edit DB settings
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `npm install && npm run dev`
7. `php artisan storage:link`
8. `php artisan serve` (runs on http://127.0.0.1:8000)

## Test accounts
- Admin: admin@test.com / password
- Reviewer: reviewer@test.com / password
- Candidate: candidate@test.com / password

## Quick demo flow
1. Login as Admin -> Create Interview -> Add questions
2. Login as Candidate -> Open Interview -> Record & Upload answers
3. Login as Reviewer -> Open Submissions -> Play video, score & comment

## Known limitations
- No email verification
- No per-interview invite/assignment — all candidates see all interviews
- Video format is webm; server doesn't convert formats
- No pagination/large-file handling beyond basic upload limits
