# Julia Rogers – INF653 Midterm Project

## Project Overview
This project is a PHP OOP REST API for storing and retrieving quotes. It includes full CRUD functionality (GET, POST, PUT, DELETE) for three models:
- Quotes
- Authors
- Categories

The backend uses:
- PHP (OOP)
- PostgreSQL for the database
- Docker for deployment
- Environment variables for secure database configuration

## API Structure

All requests return JSON and follow RESTful conventions. The base URL ends in `/api`.

### Endpoints

- `/api/quotes/`
- `/api/authors/`
- `/api/categories/`

Supports GET, POST, PUT, DELETE with required parameters.

## Database Schema

- `authors(id, author)`
- `categories(id, category)`
- `quotes(id, quote, author_id, category_id)`

All foreign keys and `NOT NULL` constraints are enforced.

## Deployment

The project was deployed using Render.com with both the database and web service hosted in the same region (Oregon). Docker was used to containerize the app.

## Notes

Despite all efforts to configure everything correctly, Render failed to resolve the internal `.internal` hostname between services. External connection on port 10000 also timed out, though the app works fully in local development.

## GitHub Repo

[Link to this repository](https://github.com/JuliaRogers13/Julia_Rogers_INF653VD_MidtermProject)

## Author

**Julia Rogers**