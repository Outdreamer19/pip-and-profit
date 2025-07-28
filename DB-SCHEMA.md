# DATABASE SCHEMA

## Tables
users (id, name, email, password, role)
courses (id, title, slug, price, description)
lessons (id, course_id, title, video_url, order)
orders (id, user_id, course_id, amount, status)

## Relationships
- User hasMany Orders
- Course hasMany Lessons
- Order belongsTo User & Course

## Action Steps
- Create migrations for tables
- Add relationships in Eloquent models
- Seed demo data for courses and lessons
