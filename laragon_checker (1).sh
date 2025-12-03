#!/bin/bash

# Configuration
LARAVEL_PATH="/c/laragon/www/laravelSU15"
LARAVEL_URL="http://127.0.0.1:8000"
GIT_REPO="https://github.com/Chensihakniroth/Pest.git"
GIT_BRANCH="ui"
LARAGON_PATH="/c/laragon/laragon.exe"

# Colors for output
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo "=== Laragon Laravel Auto-Starter ==="
echo ""

# Step 1: Check if Laragon is running, if not start it
echo "Step 1: Checking Laragon application..."
if tasklist //FI "IMAGENAME eq laragon.exe" 2>NUL | grep -q "laragon.exe"; then
    echo -e "${GREEN}✓${NC} Laragon is running"
else
    echo -e "${YELLOW}Laragon is not running. Starting Laragon...${NC}"
    if [ -f "$LARAGON_PATH" ]; then
        start "" "$LARAGON_PATH"
        echo "Waiting for Laragon to start..."
        sleep 5
        echo -e "${GREEN}✓${NC} Laragon started"
    else
        echo -e "${RED}Error: Laragon not found at $LARAGON_PATH${NC}"
        read -p "Press enter to exit..."
        exit 1
    fi
fi
echo ""

# Step 2: Check and start Laragon services if needed
echo "Step 2: Checking Laragon services..."
services_ok=true
services_started=false

# Function to check if a service is running
check_service() {
    local service_name=$1
    if tasklist //FI "IMAGENAME eq ${service_name}" 2>NUL | grep -q "$service_name"; then
        echo -e "${GREEN}✓${NC} $service_name is running"
        return 0
    else
        echo -e "${YELLOW}⚠${NC} $service_name is NOT running"
        return 1
    fi
}

# Check Apache/Nginx (adjust based on what you use)
if ! check_service "httpd.exe" && ! check_service "nginx.exe"; then
    services_ok=false
fi

# Check MySQL
if ! check_service "mysqld.exe"; then
    services_ok=false
fi

# If services are not running, try to start them
if [ "$services_ok" = false ]; then
    echo -e "${YELLOW}Some services are not running. Attempting to start all services...${NC}"
    
    # Click "Start All" in Laragon using AutoHotkey or VBScript
    # Create a temporary VBScript to start services
    cat > /tmp/start_laragon.vbs << 'EOF'
Set WshShell = CreateObject("WScript.Shell")
' Activate Laragon window
WshShell.AppActivate "Laragon"
WScript.Sleep 500
' Send Alt+G to start all services (Laragon hotkey)
WshShell.SendKeys "%G"
EOF
    
    cscript //nologo /tmp/start_laragon.vbs 2>/dev/null
    
    echo "Waiting for services to start..."
    sleep 8
    
    # Check again
    echo "Verifying services..."
    services_ok=true
    if ! check_service "httpd.exe" && ! check_service "nginx.exe"; then
        services_ok=false
    fi
    if ! check_service "mysqld.exe"; then
        services_ok=false
    fi
    
    if [ "$services_ok" = false ]; then
        echo -e "${RED}Failed to start services automatically.${NC}"
        echo -e "${YELLOW}Please manually click 'Start All' in Laragon, then press enter to continue...${NC}"
        read -p ""
    else
        echo -e "${GREEN}✓${NC} All services started successfully"
    fi
fi

# Step 3: Navigate to Laravel directory
echo "Step 3: Navigating to Laravel project..."
if [ ! -d "$LARAVEL_PATH" ]; then
    echo -e "${RED}Error: Laravel project not found at $LARAVEL_PATH${NC}"
    read -p "Press enter to exit..."
    exit 1
fi

cd "$LARAVEL_PATH" || exit 1
echo -e "${GREEN}✓${NC} Changed to $LARAVEL_PATH"
echo ""

# Step 4: Check Git status and update
echo "Step 4: Checking Git repository status..."

# Check if directory exists but is not a git repo - clone if needed
if [ ! -d ".git" ]; then
    echo -e "${YELLOW}Not a Git repository. Cloning from $GIT_REPO...${NC}"
    cd ..
    rm -rf laravelSU15
    git clone -b $GIT_BRANCH $GIT_REPO laravelSU15
    cd laravelSU15
    
    # Setup Laravel after cloning
    echo "Setting up Laravel..."
    composer install --no-interaction
    
    if [ ! -f ".env" ]; then
        cp .env.example .env
        php artisan key:generate
    fi
    
    php artisan migrate --force
    echo -e "${GREEN}✓${NC} Repository cloned and setup complete"
else
    # Ensure we're on the correct branch
    CURRENT_BRANCH=$(git branch --show-current)
    if [ "$CURRENT_BRANCH" != "$GIT_BRANCH" ]; then
        echo -e "${YELLOW}Switching to branch: $GIT_BRANCH${NC}"
        git checkout $GIT_BRANCH
    fi
    
    # Fetch latest changes
    echo "Fetching latest changes from remote..."
    git fetch origin $GIT_BRANCH
    
    # Check if local is behind remote
    LOCAL=$(git rev-parse @)
    REMOTE=$(git rev-parse @{u})
    
    if [ "$LOCAL" = "$REMOTE" ]; then
        echo -e "${GREEN}✓${NC} Repository is already up to date"
    else
        echo -e "${YELLOW}Repository is behind. Updating...${NC}"
        
        # Stash any local changes
        git stash
        
        # Pull latest changes
        git pull origin $GIT_BRANCH
        
        if [ $? -eq 0 ]; then
            echo -e "${GREEN}✓${NC} Repository updated successfully"
            
            # Install/update dependencies
            echo "Updating Composer dependencies..."
            composer install --no-interaction
            
            # Run migrations if needed
            echo "Running migrations..."
            php artisan migrate --force
            
            # Clear cache
            echo "Clearing cache..."
            php artisan cache:clear
            php artisan config:clear
            php artisan view:clear
        else
            echo -e "${RED}Error: Failed to update repository${NC}"
            read -p "Press enter to exit..."
            exit 1
        fi
    fi
fi

echo ""

# Step 5: Check PHP
echo "Step 5: Checking PHP..."
if ! command -v php &> /dev/null; then
    echo -e "${RED}Error: PHP not found in PATH${NC}"
    echo "Please ensure Laragon's PHP is in your system PATH"
    read -p "Press enter to exit..."
    exit 1
fi
php -v
echo ""

# Step 6: Check Laravel installation
echo "Step 6: Checking Laravel installation..."
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: artisan file not found. Is this a Laravel project?${NC}"
    read -p "Press enter to exit..."
    exit 1
fi

if [ ! -f ".env" ]; then
    echo -e "${YELLOW}Warning: .env file not found. Copying from .env.example...${NC}"
    cp .env.example .env
    php artisan key:generate
fi

echo -e "${GREEN}✓${NC} Laravel installation OK"
echo ""

# Step 7: Start Laravel development server
echo "Step 7: Starting Laravel development server..."

# Kill any existing PHP processes on port 8000
echo "Checking for existing server on port 8000..."
for pid in $(netstat -ano | grep ":8000" | awk '{print $5}' | sort -u); do
    if [ ! -z "$pid" ] && [ "$pid" != "0" ]; then
        echo "Killing process $pid on port 8000..."
        taskkill //F //PID $pid 2>/dev/null
    fi
done

sleep 1

# Start server in new window
echo "Starting server in new window..."
start "Laravel Server" cmd //c "cd /d C:\laragon\www\laravelSU15 && php artisan serve --host=127.0.0.1 --port=8000 && pause"

# Wait for server to be ready with better checking
echo "Waiting for server to start..."
SERVER_READY=false
for i in {1..15}; do
    sleep 1
    if curl -s http://127.0.0.1:8000 > /dev/null 2>&1; then
        echo -e "${GREEN}✓${NC} Server is ready! (attempt $i/15)"
        SERVER_READY=true
        break
    fi
    echo "Checking server... attempt $i/15"
done

if [ "$SERVER_READY" = false ]; then
    echo -e "${YELLOW}Server is taking longer than expected to start${NC}"
    echo "The server window should be open. Waiting 3 more seconds..."
    sleep 3
fi

echo ""

# Step 8: Open browser
echo "Step 8: Opening browser..."
start "$LARAVEL_URL"
echo -e "${GREEN}✓${NC} Browser opened to $LARAVEL_URL"

echo ""
echo -e "${GREEN}=== All done! ===${NC}"
echo "Your Laravel application should now be running."
