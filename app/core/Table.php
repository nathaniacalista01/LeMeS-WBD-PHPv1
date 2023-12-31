<?php
    class Table{
        public const ENUM_TYPE = "
        DO $$ 
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'source') THEN
                CREATE TYPE source AS ENUM('video','pdf');            
            END IF;
        END $$;
            
        ";
        public const ENUM_ROLE = "
        DO $$ 
        BEGIN
            IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'role') THEN
                CREATE TYPE role as ENUM('STUDENT','TEACHER','ADMIN');
            END IF;
        END $$;
        ";
        public const USER_TABLE = 
        "CREATE TABLE IF NOT EXISTS users (
            user_id SERIAL PRIMARY KEY,
            username VARCHAR(256) UNIQUE NOT NULL,
            fullname VARCHAR(256),
            password VARCHAR(256) NOT NULL,
            user_role role DEFAULT 'STUDENT',
            image_path VARCHAR(256),
            created_on TIMESTAMP DEFAULT NOW()
        )";

        public const COURSE_TABLE = 
        'CREATE TABLE IF NOT EXISTS courses(
            course_id SERIAL PRIMARY KEY, 
            title varchar(256) NOT NULL,
            description VARCHAR(256),
            image_path VARCHAR(256),
            course_password VARCHAR(256),
            release_date TIMESTAMP DEFAULT NOW()
        )';

        public const COURSE_PARTICIPANT_TABLE = 
        'CREATE TABLE IF NOT EXISTS course_participant(
            course_participant_id SERIAL PRIMARY KEY,
            course_id INT REFERENCES courses(course_id) ON DELETE CASCADE NOT NULL,
            participant_id INT REFERENCES users(user_id) ON DELETE CASCADE NOT NULL
        )';
       
        public const MODULE_TABLE = 
        ' CREATE TABLE IF NOT EXISTS modules(
            module_id SERIAL PRIMARY KEY,
            title VARCHAR(256) UNIQUE NOT NULL,
            description VARCHAR(256),
            course_id INT REFERENCES courses(course_id) ON DELETE CASCADE NOT NULL
        )';

       public const MATERIAL_TABLE = 
       "CREATE TABLE IF NOT EXISTS materials(
        material_id SERIAL PRIMARY KEY,
        title VARCHAR(256) NOT NULL,
        description VARCHAR(256),
        module_id INT REFERENCES modules(module_id) ON DELETE CASCADE NOT NULL,
        material_type source,
        material_path VARCHAR(256)
        )";
    }
    
?>