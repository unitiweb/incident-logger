#!/bin/bash
# This script initializes a Laravel application environment by checking for necessary tools,

set -e

# Check if PHP is installed
if ! command -v php &> /dev/null; then
    echo "PHP is not installed. Please install PHP first."
    exit 1
fi

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    echo "Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker compose &> /dev/null; then
    echo "Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "npm is not installed. Please install Node.js and npm first."
    exit 1
fi

# Check if composer is installed
if ! command -v composer &> /dev/null; then
    echo "Composer is not installed. Please install Composer first."
    exit 1
fi

# Check if the .env file exists, if not, copy from .env.example
cp .env.example .env
if [ -f .env ]; then
    echo ".env file already exists. Skipping copy."
else
    echo "Copying .env.example to .env"
    cp .env.example .env
fi

# Spin up the Docker environment
npm run up -- -d

# Wait for the Docker containers to be ready
echo "Waiting for Docker containers to be ready..."
sleep 10

# Install composer dependencies
npm run composer:install

# Seed the database
npm run db:seed

# Restart the Docker environment
npm run restart
