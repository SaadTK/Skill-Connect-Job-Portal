
# Skill Connect (An Online Job Portal)

## Overview

Skill Connect is a dynamic and responsive job search platform designed to connect job seekers with employers. Built using a blend of modern technologies like HTML, CSS (Bootstrap), JavaScript (jQuery, AJAX), PHP, MySQL, and others, it offers an interactive, user-friendly interface for both job seekers and employers. The platform includes a rich feature set for managing profiles, job applications, job postings, and much more.

---

## Features

### **Job Seeker Dashboard**:
- Personalized welcome message with the user's first name.
- Option to upload/change profile picture.
- Accordion interface to display:
  - Personal information.
  - Wish-listed jobs.
  - Jobs that have been applied to.
- Testimonial section to share experiences and feedback.

### **Employer Dashboard**:
- Post and edit job listings.
- View applicants for job postings and manage their statuses (e.g., Interview Scheduled, Rejected).
- Customize company profile with:
  - Upload company logo.
  - Add company name and description.

### **Job Search Features**:
- **AJAX Live Search**: Search jobs instantly by name, location, and type.
- **Lazy Loading**: Jobs are loaded progressively as the user scrolls, with a "Load More" button to reveal additional listings.
- **Category Filters**: Job categories displayed with SVG icons; click to view job listings in that category.
- **Job Wishlist**: Save jobs to a wishlist for later viewing.

### **Job Application Process**:
- Detailed job descriptions with company profiles.
- Job seekers can apply directly by uploading resumes, writing cover letters, and signing electronically via a canvas element.
- Employers can manage application statuses and contact job seekers via email.

### **Employer Branding**:
- Company profile customization, including logo and company description, for a personalized employer presence.
- Employer-driven job posting, management, and applicant tracking.

### **Real-Time Features**:
- **Redis Cache**: Displays top 5 most viewed jobs in real-time.
- **Job Statistics**: Live statistics on the number of jobs, companies, and candidates available on the platform.

### **Payment Gateway Integration**:
- **Stripe**: Allows employers to pay for job postings or premium features directly via Stripe.

### **Authentication and Authorization**:
- **GitHub Login Integration**: Job seekers and employers can log in using their GitHub accounts, streamlining registration and login, especially for tech talent.

### **Forgot Password & Email Integration**:
- **PHPMailer**: Used for sending emails, including notifications and application responses.
- **Google SMTP Server**: Utilized for sending password reset emails, making the recovery process easy and secure.

### **Weather API Integration**:
- Displays real-time weather information for a selected city.

---

## Technologies Used
- **Frontend**:
  - HTML5
  - CSS (Bootstrap)
  - JavaScript (jQuery, AJAX)
- **Backend**:
  - PHP
  - MySQL
  - Redis (for caching)
- **Authentication**:
  - GitHub OAuth for login integration
- **Payment Gateway**:
  - Stripe
- **API Integrations**:
  - OpenWeatherAPI for weather data
- **Version Control**:
  - Git & GitHub for code management

---

## Demo Link
Check out the live demo at [Skill Connect Job Portal](http://skills-connect.hopto.org).

**To test out our facilities use these accounts:**
- Employer: *employer@test.com* | Password: *1234*
- Candidate: *candidate@test.com* | Password: *1234*

### Stripe Payment Testing Credentials:
- **Successful Payment:** `4242 4242 4242 4242` (Any future date, Any 3-digit CVC, Use USA ZIP like 10001 of NY)
- **Insufficient Funds:** `4000 0000 0000 9995`
- **Expired Card:** `4000 0000 0000 0069`
- **Card Declined:** `4000 0000 0000 0002`


---

## Installation

To run the project locally, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/SaadTK/Skill-Connect-Job-Portal.git
   ```

2. Navigate to the project directory:
   ```bash
   cd Skill-Connect-Job-Portal
   ```

3. Install dependencies:
   - Make sure you have **Composer** installed (for Redis).
   - Install Redis via Composer:
     ```bash
     composer install
     ```

4. Set up your local environment:
   - Copy `.env.example` to `.env` and configure your environment variables (like database credentials, Redis settings, etc.).
   - Set up your **MySQL** database by importing the provided SQL schema found in the `database` folder.

5. Set up your web server:
   - Use Apache or Nginx to serve the project, making sure you enable PHP and configure your document root to point to the project directory.

6. Make sure the **Stripe** and **GitHub Login** credentials are set in the `.env` file. Follow the documentation for Stripe API and GitHub OAuth to get the necessary keys.

---

## Usage

1. **Job Seeker**:
   - Register or log in with GitHub.
   - Complete your profile with your personal information and upload your profile picture.
   - Browse available job listings using the search filters.
   - Apply for jobs by uploading your resume, writing a cover letter, and signing your application.
   - Save jobs to your wishlist for later.

2. **Employer**:
   - Register or log in with GitHub.
   - Customize your company profile (upload logo, add company description).
   - Post job listings and manage job statuses for applicants.
   - View applicant details and contact job seekers directly from the dashboard.

---

## Contributing

We welcome contributions to improve the Skill Connect Job Portal! To contribute, please follow these steps:

1. Fork the repository.
2. Create a new branch (`git checkout -b feature/feature-name`).
3. Make your changes and commit them (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature/feature-name`).
5. Create a pull request with a detailed explanation of the changes.

---

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## Acknowledgments

- **Bootstrap** for the responsive UI design.
- **jQuery** and **AJAX** for dynamic content loading and seamless user interactions.
- **Stripe** for payment integration.
- **Redis** for caching.
- **GitHub OAuth** for user authentication.
- **OpenWeatherAPI** for weather data integration.

