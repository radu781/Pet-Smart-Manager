from configparser import ConfigParser
import hashlib
import json
import random
import mysql.connector
from faker import Faker
from mock_data import *

ini_file = ConfigParser()
ini_file.read("config/database.ini")
sql_connection = mysql.connector.connect(
    database=ini_file.get("database", "schema"),
    user=ini_file.get("database", "username"),
    password=ini_file.get("database", "password"),
    host=ini_file.get("database", "host"),
    port="3306",
)
cursor = sql_connection.cursor()
ALLOWED_NULL_PERCENT = 33
INSERT_COUNT = 50
fk = Faker()


def random_from(source: list[str]) -> str:
    if random.randint(0, 100) < ALLOWED_NULL_PERCENT:
        return "NULL"
    return f"'{random.choice(source)}'"


def insert_pets() -> None:
    for _ in range(INSERT_COUNT):
        name = fk.first_name()
        idd = "123" + str(random.randint(0, 1_000_000))
        restrictions = random_from(foods)
        condition = random_from(diseases)
        relationship = random_from(relationships)

        statement = f"INSERT INTO pet_info (id, name, restrictions, medical_history, relationships) VALUES('{idd}', '{name}', {restrictions}, {condition}, {relationship})"
        cursor.execute(statement)
        sql_connection.commit()


def insert_users() -> None:
    passwords: list[dict[str, str]] = []

    for _ in range(INSERT_COUNT):
        name: str = fk.name()
        email: str = fk.email()
        raw_password = fk.password()
        password = hashlib.sha256(bytes(str(raw_password), "utf-8")).hexdigest()

        middle = "NULL"
        try:
            first, middle, last = [f"'{val}'" for val in name.split(" ")]
        except ValueError:
            try:
                first, last = [f"'{val}'" for val in name.split(" ")]
            except ValueError:
                continue

        statement = f"INSERT INTO `users` (email, password, firstname, middlename, lastname) VALUES('{email}', '{password}', {first}, {middle}, {last})"
        cursor.execute(statement)
        sql_connection.commit()
        passwords.append({"email": email, "password": raw_password})

    with open("config/passwords.json", "w") as file:
        json.dump(passwords, file, indent=4)


def insert_group_names() -> None:
    for _ in range(INSERT_COUNT):
        name = random.choice(groups)

        statement = f"INSERT INTO `groups` (name) VALUES('{name}')"
        cursor.execute(statement)
        sql_connection.commit()


def insert_group_members() -> None:
    cursor.execute("select * from users")
    users: list[tuple[int | str | None, ...]] = cursor.fetchall()
    user_ids: list[int] = []

    for item in users:
        idd, email, password, firstname, middlename, lastname = item
        user_ids.append(int(idd))  # type: ignore
    cursor.execute("select * from `groups`")
    groups: list[tuple[int | str, ...]] = cursor.fetchall()
    group_ids: list[int] = []

    for item in groups:
        idd, name = item
        group_ids.append(int(idd))
    for grp in group_ids:
        if random.randint(0, 100) < 33:
            user_id = random.choice(user_ids)
            statement = f"INSERT INTO group_members (group_id, user_id) values({grp}, {user_id})"
            cursor.execute(statement)
            sql_connection.commit()


# insert_pets()
insert_users()
# insert_group_names()
# insert_group_members()
