require('dotenv').config();
const express = require('express');
const path = require('path');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// CORS headers
app.use((req, res, next) => {
  res.header('Access-Control-Allow-Origin', '*');
  res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
  res.header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
  next();
});

// API Routes
app.get('/api', (req, res) => {
  res.json({ 
    message: 'Welcome to JSPRO Agency API', 
    version: '1.0.0',
    endpoints: {
      contact: 'POST /api/contact',
      services: 'GET /api/services'
    }
  });
});

// Contact form endpoint
app.post('/api/contact', (req, res) => {
  const { name, email, subject, message } = req.body;
  
  // Validate input
  if (!name || !email || !message) {
    return res.status(400).json({ error: 'Please provide all required fields' });
  }

  // In production, you would send an email using nodemailer
  console.log('Contact Form Submission:', { name, email, subject, message });
  
  res.json({ 
    success: true, 
    message: 'Thank you for your message! We will get back to you soon.' 
  });
});

// Services endpoint
app.get('/api/services', (req, res) => {
  res.json({
    services: [
      {
        id: 1,
        title: 'Web Development',
        description: 'Custom websites and web applications built with modern technologies',
        icon: 'code'
      },
      {
        id: 2,
        title: 'Mobile Apps',
        description: 'Native and cross-platform mobile applications for iOS and Android',
        icon: 'mobile'
      },
      {
        id: 3,
        title: 'UI/UX Design',
        description: 'Beautiful, intuitive designs that enhance user experience',
        icon: 'design'
      },
      {
        id: 4,
        title: 'Digital Marketing',
        description: 'Strategic marketing solutions to grow your online presence',
        icon: 'marketing'
      },
      {
        id: 5,
        title: 'Cloud Solutions',
        description: 'Scalable cloud infrastructure and deployment services',
        icon: 'cloud'
      },
      {
        id: 6,
        title: 'Consulting',
        description: 'Expert technical consulting for your digital transformation',
        icon: 'consulting'
      }
    ]
  });
});

// Serve static files from the React app in production
if (process.env.NODE_ENV === 'production') {
  app.use(express.static(path.join(__dirname, 'client', 'dist')));
  
  app.get('*', (req, res) => {
    res.sendFile(path.join(__dirname, 'client', 'dist', 'index.html'));
  });
} else {
  // In development, serve a simple HTML page
  app.get('*', (req, res) => {
    res.sendFile(path.join(__dirname, 'landing.html'));
  });
}

// Error handling middleware
app.use((err, req, res, next) => {
  console.error(err.stack);
  res.status(500).json({ error: 'Something went wrong!' });
});

app.listen(PORT, () => {
  console.log(`🚀 JSPRO Agency server running on port ${PORT}`);
  console.log(`📍 Open http://localhost:${PORT} in your browser`);
});