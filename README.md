# Pet Smart Manager

Web application that allows users to manage resources regarding their pets

## Setup

- Edit [database.ini.example](config/database.ini.example) with your configuration and rename it to [database.ini](config/database.ini).
- Run [create_tables.sql](config/create_tables.sql) to create the tables needed to store data.
- (Optional) Populate the database with random data using `py config/populate_db.py`

## Observations

Multimedia photos are saved in `multimedia/<pet_id>/<file_name>`
