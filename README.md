# VVUpload - Lead Management Portal System

![PHP](https://img.shields.io/badge/PHP-7.4%2B-blue)
![Node.js](https://img.shields.io/badge/Node.js-14%2B-green)
![React](https://img.shields.io/badge/React-19-blue)
![License](https://img.shields.io/badge/License-Proprietary-red)

##  Table of Contents

- [Overview](#overview)
- [Quick Start](#-quick-start)
- [System Architecture](#-system-architecture)
- [Setup Instructions](#-setup-instructions)
- [Data Management](#-data-management)
- [Configuration](#-configuration)
- [Usage Guide](#-usage-guide)
- [Troubleshooting](#-troubleshooting)
- [Support](#-support)
- [Updates & Maintenance](#-updates--maintenance)
- [License](#-license)

---

## Overview

VVUpload is a comprehensive centralized lead management system designed to handle multiple client portals and platforms. The system combines PHP web portals, Node.js background services, and a modern React-based digital agency website (JSPro).

### Key Features
- **Centralized Dashboard** - Access all portals from a single interface
- **Multi-Platform Integration** - Connect with various CRM and lead management APIs
- **CSV-Based Data Import** - Bulk upload leads via CSV files
- **Real-Time Processing** - Node.js services for automated lead processing
- **Database Management** - MySQL-backed data storage with enquiry tracking

---

## 🚀 Quick Start

### Access the Dashboard
1. Open your browser and navigate to: `http://localhost/vvupload/`
2. You'll see the **Portal Management Dashboard** as the main landing page
3. From there, you can access all portals and services

### Dashboard Features
- **Centralized Access**: All portals in one place
- **Real-time Statistics**: Count of active portals and data files
- **Search Functionality**: Filter portals by name or description
- **Quick Actions**: Direct links to open portals or view data files
- **Status Monitoring**: Check Node.js service status

---

## 🏗️ System Architecture

### PHP Web Portals (14 portals)

| # | Portal | Description |
|---|--------|-------------|
| 1 | **Neurons** | NoPaperForms integration with course mapping |
| 2 | **Lexicon** | CSV-based lead upload with budget tracking |
| 3 | **CC** | Database-driven enquiry management |
| 4 | **Riser** | StudyRiser bulk upload system |
| 5 | **SF** | Hong Kong leads management |
| 6 | **IES** | Educational enquiry management |
| 7 | **JKB** | Multi-target lead management |
| 8 | **LeadPush** | Online MBA lead system |
| 9 | **MPC** | Meritto test platform |
| 10 | **Ads** | Google Ads keyword research |
| 11 | **NextUni (Hindi)** | NEET score tracking |
| 12 | **NextUni Eng** | Engineering/JEE tracking |
| 13 | **Ragistan** | NoPaperForms integration |
| 14 | **BSS** | ExtraaEdge foundation system |

### Node.js Services (4 services)

| # | Service | Description |
|---|---------|-------------|
| 1 | **ISMS** | CRM integration for ISMS Pune |
| 2 | **Gest** | ReviewAdda review management |
| 3 | **Russia** | International student leads |
| 4 | **ReviewAdd** | Advanced review collection |

### JSPro - Digital Agency Website

A full-stack MERN application for a professional digital agency:

**Frontend (React + Vite + Tailwind CSS):**
- Modern responsive design with Tailwind CSS
- React Router for navigation
- Pages: Home, Services, About, Portfolio, Testimonials, Contact
- Vite for fast development and building

**Backend (Express + MongoDB):**
- RESTful API with Express.js
- MongoDB database with Mongoose ODM
- Nodemailer for email functionality
- Environment configuration with dotenv

---

## 🛠️ Setup Instructions

### Prerequisites
- **PHP** 7.4 or higher
- **MySQL/MariaDB** database server
- **Node.js** 14+ (for Node.js services)
- **npm** or **yarn** package manager
- **Composer** (optional, for PHP dependencies)
- **Local Server** (XAMPP, WAMP, Laragon, etc.)

### Database Setup
1. Create a MySQL database named `vvupload`
2. Import the SQL files from each portal folder (if available)
3. Update `config.php` with your database credentials:
```php
$conn = new mysqli("localhost", "username", "password", "database_name");
```

### PHP Portals Setup
1. Place all files in your web server directory (e.g., `c:/laragon/www/vvupload/`)
2. Ensure `.htaccess` is properly configured
3. Set appropriate file permissions
4. Access via `http://localhost/vvupload/`

### Node.js Services Setup
For each Node.js service:
```bash
cd service-name
npm install
node index.js  # or node test.js for gest
```

### JSPro Setup
```bash
# Install all dependencies (root + client)
cd jspro
npm run install-all

# Start development server
npm run dev

# Build for production
npm run build
```

### Running the System
1. Start your local server (XAMPP, WAMP, Laragon, etc.)
2. Start MySQL database server
3. Place files in `c:/laragon/www/vvupload/`
4. Access via `http://localhost/vvupload/`

---

## 📊 Data Management

### CSV File Structure
Each portal uses CSV files with specific formats:

**Standard Lead Format:**
```csv
Name,Email,Mobile,State,City,Course,Specialization
```

**Portal-Specific Formats:**

| Portal | CSV Columns |
|--------|-------------|
| **Neurons** | name, email, mobile, state, city, course |
| **Lexicon** | budget, course, name, mobile, email, city, state |
| **Riser** | preferred_stream, course, name, mobile, city, state, exam, center |
| **NextUni** | name, email, phone, city, state, course, neetScore, neetRank, resultStatus, budget, department, category, source |

### Database Tables
Common table structures across portals:
- `enquiries` - General enquiry data
- `hkleads` - Hong Kong leads
- `jkb` - JKB portal data
- `onlinemba` - LeadPush MBA data
- `keyword_data` - Ads keyword research

---

## Configuration

### Portal Configuration
Each portal has its own configuration in `index.php`:
- API URLs
- Secret keys
- Source identifiers
- College IDs

### Environment Variables (JSPro)
Create a `.env` file in the `jspro/` directory:
```env
PORT=5000
MONGODB_URI=mongodb://localhost:27017/jspro
EMAIL_HOST=smtp.gmail.com
EMAIL_PORT=587
EMAIL_USER=your-email@gmail.com
EMAIL_PASS=your-password
```

### Security
- `.htaccess` provides basic security headers
- SQL injection protection via prepared statements (where used)
- XSS protection via `htmlspecialchars()`
- File upload restrictions

---

## Usage Guide

### Using the Dashboard
1. **Search Portals**: Use the search boxes to find specific portals
2. **Open Portal**: Click "Open Portal" to access the full interface
3. **View CSV**: Click "View CSV" to see raw data files
4. **Upload Data**: Use portal-specific upload buttons

### Node.js Services
1. Open terminal in the service directory
2. Run `npm install` (first time only)
3. Run `node index.js` or `node test.js`
4. Services will process `data.csv` files automatically

### JSPro Development
```bash
# Start frontend dev server (runs on port 5173)
cd jspro/client
npm run dev

# Start backend server (runs on port 5000)
cd jspro
npm start

# Lint checking
npm run lint
```

### Best Practices
- **Backup Data**: Regularly backup CSV files and databases
- **Test First**: Use test data before bulk operations
- **Monitor Logs**: Check portal logs for errors
- **API Limits**: Be aware of API rate limits
- **Data Validation**: Ensure CSV format matches requirements

---

## Troubleshooting

### Common Issues

**Dashboard not loading:**
- Check PHP version (7.4+)
- Verify file permissions
- Check `.htaccess` is enabled

**Database connection errors:**
- Verify MySQL is running
- Check credentials in `config.php`
- Ensure database exists

**Node.js services not starting:**
- Check Node.js installation
- Run `npm install` to install dependencies
- Check for port conflicts

**CSV upload failures:**
- Verify CSV format matches requirements
- Check file encoding (UTF-8)
- Ensure no special characters in headers

**JSPro build errors:**
- Clear node_modules: `rm -rf node_modules && npm install`
- Check Node.js version compatibility
- Verify all environment variables are set

---

##  Support

For issues or questions:
1. Check portal-specific documentation
2. Review error logs in each portal
3. Verify API credentials are current
4. Test with small data sets first

---

## 🔄 Updates & Maintenance

### Regular Maintenance
- Clean up old CSV files
- Archive processed leads
- Update API credentials as needed
- Monitor database size
- Backup data regularly

### Adding New Portals
1. Create new folder with portal name
2. Add `index.php` with portal logic
3. Add configuration and API details
4. Update `dashboard.php` to include new portal
5. Test thoroughly before production use

---

## License

This system is proprietary and for internal use only.

---

**Last Updated**: June 11, 2026  
**Version**: 1.0  
**System**: VVUpload Lead Management  
**Repository**: [GitHub](git@github-work:Gaurav-rathore77/leads-upload.git)