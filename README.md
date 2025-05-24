# DHR SPACE

DHR SPACE is a revolutionary medical logistics platform in Nigeria that connects laboratories, blood banks, and patients through sophisticated technology. Our platform streamlines healthcare services by providing seamless access to medical tests, blood services, and logistics coordination.

## About DHR SPACE

DHR SPACE (D'Health Rides SPACE) is designed to make healthcare more accessible and efficient across Nigeria. We provide:

- **Lab Test Services**: Easy booking and management of laboratory tests
- **Blood Bank Services**: Streamlined blood donation and transfusion services  
- **Logistics Coordination**: Professional medical logistics and delivery services
- **Provider Network**: Comprehensive network of healthcare facilities and professionals
- **Patient Management**: Integrated patient records and health tracking

## Features

- **Multi-Role Dashboard**: Separate interfaces for consumers, healthcare providers, bikers, and administrators
- **Real-time Tracking**: Live tracking of orders and logistics
- **Secure Payment Processing**: Integrated payment gateway for seamless transactions
- **Location Services**: GPS-based facility finding and delivery coordination
- **Mobile Responsive**: Fully responsive design for all devices
- **Advanced Security**: Two-factor authentication and encrypted data handling

## Technology Stack

- **Backend**: Laravel 11 (PHP)
- **Frontend**: Blade Templates with Alpine.js
- **Database**: MySQL
- **Admin Panel**: Filament
- **Styling**: TailwindCSS
- **Maps Integration**: Google Maps API
- **Payment Processing**: Integrated payment gateways

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd medlab-access
```

2. Install dependencies:
```bash
composer install
npm install
```

3. Configure environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up database:
```bash
php artisan migrate
php artisan db:seed
```

5. Build assets:
```bash
npm run build
```

6. Start the application:
```bash
php artisan serve
```

## Configuration

### Environment Variables

Configure the following in your `.env` file:

```env
APP_NAME="DHR SPACE"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dhr_space
DB_USERNAME=root
DB_PASSWORD=

GOOGLE_MAPS_API_KEY=your_google_maps_api_key
```

## User Roles

- **Consumer**: End users who book services and track orders
- **Provider**: Healthcare facilities (labs, blood banks, hospitals)
- **Biker**: Logistics personnel handling pickups and deliveries
- **Admin**: System administrators managing the entire platform

## Contributing

We welcome contributions to DHR SPACE! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Submit a pull request

## Security

If you discover a security vulnerability, please send an email to security@dhrspace.ng. All security vulnerabilities will be promptly addressed.

## License

DHR SPACE is proprietary software. All rights reserved.

## Support

For support and inquiries:
- Email: support@dhrspace.ng
- Phone: +234-XXX-XXX-XXXX
- Website: https://dhrspace.ng
