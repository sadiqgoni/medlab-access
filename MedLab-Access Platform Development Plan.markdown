# MedLab-Access Platform Development Plan

## Overview
MedLab-Access is a Laravel-based medical logistics platform for Nigeria, facilitating laboratory test requests, sample transport, and blood donation logistics. The platform comprises **eMedSample** (lab sample transport and report delivery) and **SharedBlood** (blood donation, screening, and transport). It will be developed in four phases over 8 weeks (April 26, 2025 - June 21, 2025) by a team of three: Sadiq Goni (developer), Auwal Muktar (project manager), and Sani Abdullahi (analyst). The project uses **Laravel Filament** for admin/user interfaces, **Cursor AI Pro** ($20/month, ~60,000 NGN for 2 months) for code generation, and **v0** (free tier) for optional landing page UI prototyping. It will be hosted on **Hostinger Premium** with a 200,000 NGN miscellaneous budget for APIs (Paystack, Mapbox, Twilio).

## Objectives
- Deliver a scalable Minimum Viable Product (MVP) in Phase 1, followed by advanced features, payment/notification systems, and optimization in subsequent phases.
- Ensure compliance with medical data protection standards (e.g., NDPR in Nigeria).
- Provide a user-friendly interface for consumers, service providers, delivery riders, and admins.
- Enable real-time tracking, notifications, and secure payment processing.
- Train client staff for smooth platform adoption.

## System Architecture
- **Frontend**: Laravel Blade with Tailwind CSS for responsive design, Filament v3 for admin/provider dashboards, custom Blade for consumer-facing pages (landing, order forms).
- **Backend**: Laravel 11 (APIs, controllers, Eloquent ORM for data management), Laravel Sanctum for authentication.
- **Database**: MySQL on Hostinger, with tables for:
  - Users (consumers, providers, bikers, admins)
  - Orders (tests, blood requests)
  - Facilities (services, locations)
  - Logs (samples, results, deliveries)
  - Transactions (payments, statuses)
- **APIs**:
  - **Paystack**: Payment processing (cards, bank transfers, ~10,000 NGN).
  - **Mapbox**: Real-time GPS tracking for bikers (~20,000 NGN).
  - **Twilio**: SMS notifications for order updates (~10,000 NGN).
  - **Pusher**: Real-time notifications for order status (~5,000 NGN).
- **Authentication**: Laravel Breeze/Sanctum with email/password, OTP via Twilio, OAuth (Google, Facebook), and role-based access control (RBAC).
- **Hosting**: Hostinger Premium (PHP 8.2, MySQL, Git deployment, domain/DNS setup).
- **Tools**:
  - **Cursor AI Pro**: AI-assisted coding for Laravel components.
  - **v0**: Optional UI prototyping for landing page.
  - **Trello**: Project management and task tracking.
  - **Postman**: API testing.
  - **GitHub**: Version control and code collaboration.

## Actors & Roles
1. **Consumer (Patient/Individual)**:
   - Registers, places orders (lab tests or blood requests), tracks deliveries, views results, manages profile.
   - Accesses landing page, order forms, tracking maps, and result PDFs.
2. **Service Provider (Lab/Hospital)**:
   - Registers facilities, manages services, accepts orders, inputs test results, updates logs, edits profiles.
   - Uses dashboards, LIMS, and log sheets.
3. **DHR Biker (Delivery Rider)**:
   - Accepts delivery tasks, updates statuses, navigates via GPS.
   - Accesses task lists and map interfaces.
4. **Admin**:
   - Manages users, facilities, orders; resolves disputes; monitors analytics.
   - Uses Filament admin panel for oversight.

## Screens
### Consumer
- **Landing Page**: Public page with platform info, services (eMedSample, SharedBlood), and registration CTA.
- **Registration/Login**: Form capturing name, email, phone, address, government ID, blood donation eligibility, preferred communication (SMS/email/app).
- **Order Form**: Select test/blood type, facility, and payment method (Paystack).
- **Order Tracking**: Mapbox-powered map showing rider location and order status (Pending, In Progress, Completed).
- **Results View**: View/download test results as PDF from LIMS.
- **Profile Page**: Edit personal details, view order history, set communication preferences.

### Service Provider
- **Facility Dashboard**: Overview of orders, services, and logs.
- **Order Management**: Accept/reject orders, update statuses (e.g., "Testing").
- **LIMS Panel**: Input test results, track samples, generate reports.
- **Log Sheets**: Digital logs for samples, results, and blood drives.
- **Profile Page**: Edit facility details (services, location, availability).

### DHR Biker
- **Task List**: View assigned deliveries (order ID, pickup/drop-off locations).
- **GPS Map**: Real-time Mapbox navigation for pickup/delivery.
- **Status Update**: Form to update order status (Picked Up, In Transit, Delivered).

### Admin
- **Admin Dashboard**: Analytics on orders, users, and facilities.
- **User Management**: Create, read, update, delete (CRUD) operations for all user types.
- **Order Overview**: Monitor all orders, resolve disputes.
- **Facility Management**: Approve/reject facility registrations.

## User Workflows
### Consumer
1. Visits landing page, clicks “Register.”
2. Submits registration form (name, email, phone, address, ID, blood donation details).
3. Logs in (email/password or OTP via Twilio).
4. Places order (selects test/blood type, facility, pays via Paystack).
5. Tracks order on Mapbox map (real-time rider location, status updates).
6. Receives SMS/email notifications (e.g., “Order #123 Dispatched” via Twilio/Pusher).
7. Views results in app or downloads PDF from LIMS.
8. Updates profile (e.g., adds emergency contact).

### Service Provider
1. Registers facility (services, location, credentials).
2. Logs in, views Filament dashboard.
3. Accepts incoming order, updates status (e.g., “Sample Received”).
4. Uses LIMS to input test results, generate reports.
5. Updates digital log sheets for sample tracking.
6. Edits facility profile (e.g., adds new service).

### DHR Biker
1. Logs in, views task list.
2. Accepts delivery task (e.g., sample pickup from lab).
3. Navigates to pickup/drop-off using Mapbox GPS.
4. Updates status (e.g., “Delivered”).
5. Receives SMS for new tasks via Twilio.

### Admin
1. Logs in to Filament admin panel, views analytics.
2. Manages users (e.g., suspends fraudulent consumer).
3. Approves facility registrations.
4. Resolves disputes (e.g., “Results not delivered”).
5. Monitors system performance and order statuses.

## System Workflow
1. **Order Initiation**:
   - Consumer places order via form (test/blood, facility selection).
   - System matches order to nearest facility based on location and services (using Mapbox geocoding).
2. **Order Processing**:
   - Facility accepts order, assigns DHR Biker.
   - Consumer pays via Paystack (card, bank transfer, or cash logged).
3. **Delivery**:
   - Biker picks up sample/blood, updates status, navigates with Mapbox.
   - System sends notifications (SMS via Twilio, real-time via Pusher).
4. **Testing/Delivery**:
   - Facility receives sample, inputs results in LIMS (for tests).
   - For blood, Biker delivers to hospital/consumer.
5. **Completion**:
   - Results uploaded to LIMS, consumer notified (SMS/email).
   - Consumer views results, system logs transaction in MySQL.
6. **Admin Oversight**:
   - Admin monitors orders, resolves issues, approves facilities via Filament panel.

## Development Roadmap (8 Weeks)
### Week 1-2: Phase 1 - MVP Development (April 26 - May 9, 2025)
- **Tasks**:
  - Set up Hostinger Premium (domain, DNS, MySQL, PHP 8.2).
  - Initialize Laravel 11 project with Filament v3 and Laravel Breeze/Sanctum.
  - Design responsive landing page (Blade + Tailwind, optional v0 prototype).
  - Implement user registration forms (consumer, provider, biker) with RBAC.
  - Develop authentication (email/password, OTP via Twilio, OAuth).
  - Create order placement form and basic order management (Eloquent models).
  - Set up Mapbox for real-time GPS tracking (biker map view).
  - Build LIMS core (sample tracking, result input, report generation).
  - Ensure NDPR-compliant data security (encryption, secure APIs).
- **Deliverables**:
  - Landing page live on domain.
  - User registration/login for all roles.
  - Order placement and tracking (basic).
  - LIMS prototype (sample/result tracking).
- **Team**:
  - Sadiq: Code landing page, auth, order system, LIMS (using Cursor AI).
  - Auwal: Set up Trello, track tasks, coordinate APIs.
  - Sani: Define database schema, validate requirements.

### Week 3-4: Phase 2 - Payment & Notification System (May 10 - May 23, 2025)
- **Tasks**:
  - Integrate Paystack for payments (cards, bank transfers, cash logging).
  - Implement transaction status notifications (SMS via Twilio).
  - Develop real-time notification system (Pusher for order updates).
  - Enhance order management (status updates, provider acceptance).
  - Test APIs with Postman (Paystack, Twilio, Pusher).
- **Deliverables**:
  - Functional payment gateway.
  - Real-time notifications for order/payment statuses.
  - Enhanced order management UI.
- **Team**:
  - Sadiq: Code Paystack/Pusher integrations, notification logic.
  - Auwal: Monitor API budget, test notifications.
  - Sani: Validate payment workflows, document edge cases.

### Week 5-6: Phase 3 - Advanced Features & Logistics (May 24 - June 6, 2025)
- **Tasks**:
  - Digitize log sheets (sample, result, blood drive logs in MySQL).
  - Develop client self-description pages (consumer/provider profiles).
  - Build facility registration/discovery system (search by service/location).
  - Enhance LIMS with report generation and patient history.
  - Optimize Mapbox GPS for biker routes (shortest path).
- **Deliverables**:
  - Digital log sheets integrated.
  - Profile pages for consumers/providers.
  - Facility discovery system.
  - Advanced LIMS features.
- **Team**:
  - Sadiq: Code log sheets, profiles, facility system, LIMS enhancements.
  - Auwal: Coordinate testing, manage timeline.
  - Sani: Validate facility matching logic, review UI/UX.

### Week 7-8: Phase 4 - Optimization & Deployment (June 7 - June 21, 2025)
- **Tasks**:
  - Optimize GPS tracking (Mapbox performance).
  - Conduct performance testing (load handling, bug fixes).
  - Enhance UI/UX (Filament dashboards, consumer pages).
  - Implement security measures (CSRF, XSS protection, NDPR compliance).
  - Deploy to Hostinger (Git-based deployment).
  - Train client staff (500,000 NGN budget, 1-week program).
- **Deliverables**:
  - Fully optimized platform.
  - Live deployment on Hostinger.
  - Staff training completed.
- **Team**:
  - Sadiq: Optimize code, deploy, assist training.
  - Auwal: Oversee deployment, coordinate training.
  - Sani: Document training materials, validate system.

## Budget Alignment
- **Development (Phases 1-4)**: 3,530,000 NGN (per BOQ).
- **Training Fees**: 500,000 NGN.
- **Contingency (5%)**: 176,500 NGN.
- **APIs/Tools**: ~65,000 NGN (Paystack, Mapbox, Twilio, Pusher, Cursor AI).
- **Hosting**: Included in misc. budget (200,000 NGN).
- **Total**: ~4,206,500 NGN (aligned with BOQ).

## Risks & Mitigation
- **Risk**: API costs exceed budget.
  - **Mitigation**: Monitor usage weekly, prioritize free tiers (e.g., Mapbox/Twilio sandbox).
- **Risk**: Timeline delays due to bugs.
  - **Mitigation**: Use Cursor AI for rapid debugging, allocate Week 7 for fixes.
- **Risk**: Client staff struggle with platform.
  - **Mitigation**: Comprehensive training, user-friendly Filament UI.

## Next Steps
1. Confirm plan with client by April 28, 2025.
2. Set up Hostinger and Trello by April 29, 2025.
3. Begin Phase 1 development on April 30, 2025.
4. Schedule weekly client demos (every Friday).