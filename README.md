<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skill Connect - An Online Job Portal</title>
</head>
<body>
    <h1>Skill Connect</h1>
    <h2>An Online Job Portal</h2>
    <hr>
    
    <h3>Overview</h3>
    <p>
        <b>Skill Connect</b> is a dynamic and responsive job search platform designed to connect job seekers with employers. 
        Built using a blend of modern technologies like HTML, CSS (Bootstrap), JavaScript (jQuery, AJAX), PHP, MySQL, 
        and others, it offers an interactive, user-friendly interface for both job seekers and employers. The platform 
        includes a rich feature set for managing profiles, job applications, job postings, and much more.
    </p>
    
    <hr>
    
    <h3>Features</h3>
    
    <h4>Job Seeker Dashboard</h4>
    <ul>
        <li>Personalized welcome message with the user's first name.</li>
        <li>Option to upload/change profile picture.</li>
        <li>
            Accordion interface to display:
            <ul>
                <li>Personal information.</li>
                <li>Wish-listed jobs.</li>
                <li>Jobs that have been applied to.</li>
            </ul>
        </li>
        <li>Testimonial section to share experiences and feedback.</li>
    </ul>
    
    <h4>Employer Dashboard</h4>
    <ul>
        <li>Post and edit job listings.</li>
        <li>View applicants for job postings and manage their statuses (e.g., Interview Scheduled, Rejected).</li>
        <li>
            Customize company profile with:
            <ul>
                <li>Upload company logo.</li>
                <li>Add company name and description.</li>
            </ul>
        </li>
    </ul>
    
    <h4>Job Search Features</h4>
    <ul>
        <li><b>AJAX Live Search:</b> Search jobs instantly by name, location, and type.</li>
        <li><b>Lazy Loading:</b> Jobs are loaded progressively as the user scrolls, with a "Load More" button to reveal additional listings.</li>
        <li><b>Category Filters:</b> Job categories displayed with SVG icons; click to view job listings in that category.</li>
        <li><b>Job Wishlist:</b> Save jobs to a wishlist for later viewing.</li>
    </ul>
    
    <h4>Job Application Process</h4>
    <ul>
        <li>Detailed job descriptions with company profiles.</li>
        <li>Job seekers can apply directly by uploading resumes, writing cover letters, and signing electronically via a canvas element.</li>
        <li>Employers can manage application statuses and contact job seekers via email.</li>
    </ul>
    
    <h4>Employer Branding</h4>
    <ul>
        <li>Company profile customization, including logo and company description, for a personalized employer presence.</li>
        <li>Employer-driven job posting, management, and applicant tracking.</li>
    </ul>
    
    <h4>Real-Time Features</h4>
    <ul>
        <li><b>Redis Cache:</b> Displays top 5 most viewed jobs in real-time.</li>
        <li><b>Job Statistics:</b> Live statistics on the number of jobs, companies, and candidates available on the platform.</li>
    </ul>
    
    <h4>Payment Gateway Integration</h4>
    <ul>
        <li><b>Stripe:</b> Allows employers to pay for job postings or premium features directly via Stripe.</li>
    </ul>
    
    <h4>Authentication and Authorization</h4>
    <ul>
        <li><b>GitHub Login Integration:</b> Job seekers and employers can log in using their GitHub accounts, streamlining registration and login, especially for tech talent.</li>
    </ul>
    
    <h4>Forgot Password & Email Integration</h4>
    <ul>
        <li><b>PHPMailer:</b> Used for sending emails, including notifications and application responses.</li>
        <li><b>Google SMTP Server:</b> Utilized for sending password reset emails, making the recovery process easy and secure.</li>
    </ul>
    
    <h4>Weather API Integration</h4>
    <ul>
        <li>Displays real-time weather information for a selected city.</li>
    </ul>
    
    <hr>
    
    <h3>Technologies Used</h3>
    <ul>
        <li><b>Frontend:</b> HTML5, CSS (Bootstrap), JavaScript (jQuery, AJAX)</li>
        <li><b>Backend:</b> PHP, MySQL, Redis (for caching)</li>
        <li><b>Authentication:</b> GitHub OAuth for login integration</li>
        <li><b>Payment Gateway:</b> Stripe</li>
        <li><b>API Integrations:</b> OpenWeatherAPI for weather data</li>
        <li><b>Version Control:</b> Git & GitHub for code management</li>
    </ul>
    
    <hr>
    
    <h3>Demo Link</h3>
    <p>Check out the live demo at <a href="http://skillconnect.webhop.me" target="_blank">Skill Connect Job Portal</a>.</p>
    <p>
        <b>To test out our facilities use these accounts:</b><br>
        Employer: <i>employer@test.com</i> | Password: <i>1234</i><br>
        Candidate: <i>candidate@test.com</i> | Password: <i>1234</i>
    </p>
    
    <h4>Stripe Payment Testing Credentials:</h4>
    <ul>
        <li><b>Successful Payment:</b> 4242 4242 4242 4242 (Any future date, Any 3-digit CVC)</li>
        <li><b>Insufficient Funds:</b> 4000 0000 0000 9995</li>
        <li><b>Expired Card:</b> 4000 0000 0000 0069</li>
        <li><b>Card Declined:</b> 4000 0000 0000 0002</li>
    </ul>
    
    <hr>
    
    <h3>Installation</h3>
    <ol>
        <li>
            <b>Clone the repository:</b><br>
            <code>git clone https://github.com/SaadTK/Skill-Connect-Job-Portal.git</code>
        </li>
        <li>
            <b>Navigate to the project directory:</b><br>
            <code>cd Skill-Connect-Job-Portal</code>
        </li>
        <li>
            <b>Install dependencies:</b>
            <ul>
                <li>Ensure Composer is installed.</li>
                <li>Install Redis via Composer: <code>composer install</code></li>
            </ul>
        </li>
        <li>
            <b>Set up the local environment:</b>
            <ul>
                <li>Copy <code>.env.example</code> to <code>.env</code>.</li>
                <li>Configure your environment variables (e.g., database credentials, Redis settings).</li>
                <li>Set up MySQL database by importing the SQL schema from the <code>database</code> folder.</li>
            </ul>
        </li>
        <li>
            <b>Set up your web server:</b><br>
            Use Apache or Nginx, enable PHP, and configure the document root to point to the project directory.
        </li>
        <li>
            <b>Set up Stripe and GitHub credentials:</b> Add them to the <code>.env</code> file.
        </li>
    </ol>
    
    <hr>
    
    <h3>Usage</h3>
    <h4>Job Seeker</h4>
    <ul>
        <li>Register or log in with GitHub.</li>
        <li>Complete your profile and upload a profile picture.</li>
        <li>Browse available job listings using search filters.</li>
        <li>Apply for jobs by uploading resumes, writing cover letters, and signing applications.</li>
        <li>Save jobs to your wishlist for later.</li>
    </ul>
    
    <h4>Employer</h4>
    <ul>
        <li>Register or log in with GitHub.</li>
        <li>Customize your company profile (logo, description).</li>
        <li>Post and manage job listings.</li>
        <li>View and contact job applicants.</li>
    </ul>
    
    <hr>
    
    <h3>Contributing</h3>
    <p>We welcome contributions! Follow these steps:</p>
    <ol>
        <li>Fork the repository.</li>
        <li>Create a new branch: <code>git checkout -b feature/feature-name</code></li>
        <li>Make changes and commit: <code>git commit -am 'Add new feature'</code></li>
        <li>Push to the branch: <code>git push origin feature/feature-name</code></li>
        <li>Create a pull request with detailed explanation.</li>
    </ol>
    
    <hr>
    
    <h3>License</h3>
    <p>This project is licensed under the MIT License. See the <a href="LICENSE" target="_blank">LICENSE</a> file for details.</p>
    
    <hr>
    
    <h3>Acknowledgments</h3>
    <ul>
        <li>Bootstrap for responsive UI design.</li>
        <li>jQuery and AJAX for seamless user interactions.</li>
        <li>Stripe for payment integration.</li>
        <li>Redis for caching.</li>
        <li>GitHub OAuth for authentication.</li>
        <li>OpenWeatherAPI for weather data integration.</li>
    </ul>
</body>
</html>
