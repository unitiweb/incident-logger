cd ..

# Check if npm is installed
if ! command -v npm &> /dev/null; then
    echo "npm is not installed. Please install Node.js and npm first."
    exit 1
fi

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

# Generate application key
php artisan key:generate

# Spin up the Docker environment
npm run up

# Install composer dependencies
npm run composer:install

# Seed the database
npm run db:seed
