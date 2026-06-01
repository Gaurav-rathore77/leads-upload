import { Link } from 'react-router-dom'

// Icons as components
const CodeIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-8 h-8">
    <path strokeLinecap="round" strokeLinejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
  </svg>
)

const MobileIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-8 h-8">
    <path strokeLinecap="round" strokeLinejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
  </svg>
)

const DesignIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-8 h-8">
    <path strokeLinecap="round" strokeLinejoin="round" d="M9.53 16.122a3 3 0 0 0-5.78 1.128 2.25 2.25 0 0 1-2.4 2.245 4.5 4.5 0 0 0 8.4-2.245c0-.399-.078-.78-.22-1.128Zm0 0a15.998 15.998 0 0 0 3.388-1.62m-5.04 3.02A16.004 16.004 0 0 0 12 21c1.705 0 3.334-.266 4.87-.758m-6.52-4.122a15.996 15.996 0 0 1-1.62-3.388m1.62 3.388a15.997 15.997 0 0 1-3.388-1.62m0 0a15.998 15.998 0 0 0-1.62-3.388m1.62 3.388a16.002 16.002 0 0 1 3.388-1.62m0 0a15.998 15.998 0 0 0 1.62-3.388m3.388 1.62a15.998 15.998 0 0 0 1.62 3.388M12 3v2.25" />
  </svg>
)

const MarketingIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-8 h-8">
    <path strokeLinecap="round" strokeLinejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.43.816 1.035.816 1.73 0 .695-.32 1.3-.816 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46" />
  </svg>
)

const CloudIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-8 h-8">
    <path strokeLinecap="round" strokeLinejoin="round" d="M12 16.5V9.75m0 0 3 3.75m-3-3.75-3 3.75M12 9.75V4.5m6.75 9.75v2.25a2.25 2.25 0 0 1-2.25 2.25H7.5A2.25 2.25 0 0 1 5.25 16.5v-2.25m6.75-3V9.75m0 0h2.25a2.25 2.25 0 0 1 2.25 2.25v2.25m-9 0h9" />
  </svg>
)

const ConsultingIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-8 h-8">
    <path strokeLinecap="round" strokeLinejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.111 48.111 0 0 1-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
  </svg>
)

const CheckIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5 text-green-500">
    <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
  </svg>
)

const StarIcon = () => (
  <svg viewBox="0 0 20 20" className="w-5 h-5 text-yellow-400 fill-current">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
  </svg>
)

// Hero Section
function Hero() {
  return (
    <section className="min-h-screen flex items-center pt-20 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
      {/* Background decoration */}
      <div className="absolute top-20 right-0 w-96 h-96 bg-primary-100 rounded-full blur-3xl opacity-50 animate-float" />
      <div className="absolute bottom-20 left-0 w-72 h-72 bg-purple-100 rounded-full blur-3xl opacity-50 animate-float" style={{ animationDelay: '2s' }} />

      <div className="container mx-auto px-6 py-20">
        <div className="grid lg:grid-cols-2 gap-12 items-center">
          <div className="animate-fade-in-up">
            <h1 className="text-5xl lg:text-6xl font-black text-secondary leading-tight mb-6">
              Transforming Ideas Into{' '}
              <span className="gradient-text">Digital Excellence</span>
            </h1>
            <p className="text-xl text-gray-600 mb-8 max-w-lg">
              We are a full-service digital agency crafting beautiful websites, powerful applications, and memorable brand experiences that drive results.
            </p>
            <div className="flex flex-wrap gap-4 mb-12">
              <Link to="/contact" className="btn btn-primary btn-large">
                Start Your Project
              </Link>
              <Link to="/portfolio" className="btn btn-secondary btn-large">
                View Our Work
              </Link>
            </div>
            <div className="flex gap-8 pt-8 border-t border-gray-200">
              <div>
                <div className="text-4xl font-black text-primary-600">150+</div>
                <div className="text-gray-500">Projects Delivered</div>
              </div>
              <div>
                <div className="text-4xl font-black text-primary-600">50+</div>
                <div className="text-gray-500">Happy Clients</div>
              </div>
              <div>
                <div className="text-4xl font-black text-primary-600">99%</div>
                <div className="text-gray-500">Client Satisfaction</div>
              </div>
            </div>
          </div>

          <div className="hidden lg:block animate-fade-in-up" style={{ animationDelay: '0.2s' }}>
            <div className="relative">
              <div className="bg-gradient-to-br from-primary-600 to-purple-600 rounded-3xl p-8 shadow-2xl">
                <div className="bg-white rounded-2xl p-6">
                  <div className="flex gap-2 mb-4">
                    <div className="w-3 h-3 rounded-full bg-red-500" />
                    <div className="w-3 h-3 rounded-full bg-yellow-500" />
                    <div className="w-3 h-3 rounded-full bg-green-500" />
                  </div>
                  <div className="space-y-3">
                    <div className="h-4 bg-gray-200 rounded w-3/4" />
                    <div className="h-4 bg-gray-200 rounded w-full" />
                    <div className="h-4 bg-gray-200 rounded w-5/6" />
                    <div className="h-4 bg-gray-200 rounded w-2/3" />
                  </div>
                  <div className="mt-6 flex gap-3">
                    <div className="px-4 py-2 bg-primary-600 text-white rounded-lg text-sm font-medium">Deploy</div>
                    <div className="px-4 py-2 bg-gray-100 rounded-lg text-sm font-medium">Preview</div>
                  </div>
                </div>
              </div>
              {/* Floating cards */}
              <div className="absolute -left-8 top-1/4 bg-white rounded-xl shadow-xl p-4 animate-float">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center text-white">✓</div>
                  <div>
                    <div className="font-semibold text-secondary">Project Completed</div>
                    <div className="text-sm text-gray-500">E-commerce Platform</div>
                  </div>
                </div>
              </div>
              <div className="absolute -right-4 bottom-1/4 bg-white rounded-xl shadow-xl p-4 animate-float" style={{ animationDelay: '1.5s' }}>
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 bg-gradient-to-br from-primary-600 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">5.0</div>
                  <div>
                    <div className="font-semibold text-secondary">5-Star Rating</div>
                    <div className="text-sm text-gray-500">From Client</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

// Services Preview Section
function ServicesPreview() {
  const services = [
    { icon: <CodeIcon />, title: 'Web Development', description: 'Custom websites and web applications built with modern technologies like React, Node.js, and cloud infrastructure.' },
    { icon: <MobileIcon />, title: 'Mobile Apps', description: 'Native and cross-platform mobile applications for iOS and Android that deliver exceptional user experiences.' },
    { icon: <DesignIcon />, title: 'UI/UX Design', description: 'Beautiful, intuitive designs that enhance user experience and drive engagement across all digital touchpoints.' },
    { icon: <MarketingIcon />, title: 'Digital Marketing', description: 'Strategic marketing solutions including SEO, PPC, social media, and content marketing to grow your online presence.' },
    { icon: <CloudIcon />, title: 'Cloud Solutions', description: 'Scalable cloud infrastructure, deployment, and management services on AWS, Google Cloud, and Azure platforms.' },
    { icon: <ConsultingIcon />, title: 'Consulting', description: 'Expert technical consulting for digital transformation, architecture review, and technology strategy planning.' },
  ]

  return (
    <section className="section-padding bg-gray-50">
      <div className="container mx-auto px-6">
        <div className="text-center max-w-2xl mx-auto mb-16">
          <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
            Our Services
          </span>
          <h2 className="text-4xl font-bold text-secondary mb-4">What We Offer</h2>
          <p className="text-lg text-gray-600">
            Comprehensive digital solutions tailored to your business needs, from concept to deployment and beyond.
          </p>
        </div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {services.map((service, index) => (
            <div key={index} className="card p-8 group">
              <div className="w-16 h-16 bg-gradient-to-br from-primary-600 to-purple-600 rounded-xl flex items-center justify-center text-white mb-6 group-hover:scale-110 transition-transform">
                {service.icon}
              </div>
              <h3 className="text-xl font-bold text-secondary mb-3">{service.title}</h3>
              <p className="text-gray-600">{service.description}</p>
            </div>
          ))}
        </div>

        <div className="text-center mt-12">
          <Link to="/services" className="btn btn-primary btn-large">
            View All Services
          </Link>
        </div>
      </div>
    </section>
  )
}

// About Preview Section
function AboutPreview() {
  return (
    <section className="section-padding">
      <div className="container mx-auto px-6">
        <div className="grid lg:grid-cols-2 gap-16 items-center">
          <div>
            <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
              About Us
            </span>
            <h2 className="text-4xl font-bold text-secondary mb-6">
              We Build Digital Products That Matter
            </h2>
            <p className="text-lg text-gray-600 mb-6">
              At JSPRO, we believe in creating digital experiences that not only look beautiful but also drive real business results. Our team of passionate developers, designers, and strategists work together to bring your vision to life.
            </p>
            <p className="text-lg text-gray-600 mb-8">
              With years of experience in the industry, we've helped startups and enterprises alike transform their digital presence and achieve their goals.
            </p>
            <div className="grid sm:grid-cols-2 gap-4">
              {['Expert Team', '24/7 Support', 'Agile Process', 'On-Time Delivery'].map((item) => (
                <div key={item} className="flex items-center gap-3">
                  <CheckIcon />
                  <span className="font-medium text-secondary">{item}</span>
                </div>
              ))}
            </div>
          </div>
          <div className="relative">
            <div className="bg-gradient-to-br from-primary-600 to-purple-600 rounded-3xl p-8 shadow-2xl">
              <div className="bg-white rounded-2xl p-8 text-center">
                <div className="w-24 h-24 bg-gradient-to-br from-primary-600 to-purple-600 rounded-full flex items-center justify-center text-white text-4xl font-black mx-auto mb-4">
                  JS
                </div>
                <div className="h-3 bg-gray-200 rounded w-3/4 mx-auto mb-3" />
                <div className="h-3 bg-gray-200 rounded w-1/2 mx-auto mb-6" />
                <div className="px-6 py-3 bg-primary-600 text-white rounded-lg inline-block font-semibold">
                  Get Started
                </div>
              </div>
            </div>
            <div className="absolute -bottom-6 -left-6 bg-gradient-to-br from-primary-600 to-purple-600 text-white rounded-2xl p-6 shadow-xl">
              <div className="text-5xl font-black">8+</div>
              <div className="text-primary-100">Years Experience</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  )
}

// Portfolio Preview Section
function PortfolioPreview() {
  const projects = [
    { title: 'E-Commerce Platform', desc: 'Full-stack e-commerce solution with React & Node.js', gradient: 'from-primary-600 to-purple-600' },
    { title: 'Mobile Banking App', desc: 'Secure mobile banking experience for iOS & Android', gradient: 'from-purple-600 to-accent' },
    { title: 'Healthcare Dashboard', desc: 'Patient management and analytics platform', gradient: 'from-green-500 to-primary-600' },
  ]

  return (
    <section className="section-padding bg-gray-50">
      <div className="container mx-auto px-6">
        <div className="text-center max-w-2xl mx-auto mb-16">
          <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
            Our Work
          </span>
          <h2 className="text-4xl font-bold text-secondary mb-4">Featured Projects</h2>
          <p className="text-lg text-gray-600">
            Explore our portfolio of successful projects that have helped businesses achieve their digital goals.
          </p>
        </div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {projects.map((project, index) => (
            <div key={index} className="card overflow-hidden group">
              <div className={`h-48 bg-gradient-to-br ${project.gradient} flex items-center justify-center`}>
                <div className="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                  <CodeIcon />
                </div>
              </div>
              <div className="p-6">
                <h3 className="text-xl font-bold text-secondary mb-2">{project.title}</h3>
                <p className="text-gray-600">{project.desc}</p>
              </div>
            </div>
          ))}
        </div>

        <div className="text-center mt-12">
          <Link to="/portfolio" className="btn btn-primary btn-large">
            View All Projects
          </Link>
        </div>
      </div>
    </section>
  )
}

// Testimonials Preview Section
function TestimonialsPreview() {
  const testimonials = [
    {
      text: "JSPRO transformed our online presence completely. Their team delivered a stunning website that exceeded our expectations and helped us increase conversions by 200%.",
      author: "John Doe",
      role: "CEO, TechStart Inc.",
      initials: "JD"
    },
    {
      text: "Working with JSPRO was a game-changer for our business. They built a custom mobile app that our customers love, and their support has been exceptional throughout.",
      author: "Sarah Mitchell",
      role: "Founder, HealthPlus",
      initials: "SM"
    },
    {
      text: "The team at JSPRO is incredibly skilled and professional. They delivered our project on time and within budget, and the results have been outstanding.",
      author: "Michael Roberts",
      role: "CTO, FinanceFlow",
      initials: "MR"
    }
  ]

  return (
    <section className="section-padding">
      <div className="container mx-auto px-6">
        <div className="text-center max-w-2xl mx-auto mb-16">
          <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
            Testimonials
          </span>
          <h2 className="text-4xl font-bold text-secondary mb-4">What Our Clients Say</h2>
          <p className="text-lg text-gray-600">
            Don't just take our word for it. Here's what our clients have to say about working with us.
          </p>
        </div>

        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {testimonials.map((testimonial, index) => (
            <div key={index} className="card p-8">
              <div className="flex gap-1 mb-4">
                {[...Array(5)].map((_, i) => (
                  <StarIcon key={i} />
                ))}
              </div>
              <p className="text-gray-700 mb-6 italic">"{testimonial.text}"</p>
              <div className="flex items-center gap-4">
                <div className="w-12 h-12 bg-gradient-to-br from-primary-600 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                  {testimonial.initials}
                </div>
                <div>
                  <div className="font-semibold text-secondary">{testimonial.author}</div>
                  <div className="text-sm text-gray-500">{testimonial.role}</div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  )
}

// CTA Section
function CTA() {
  return (
    <section className="section-padding bg-gradient-to-r from-primary-600 to-purple-600 text-white">
      <div className="container mx-auto px-6 text-center">
        <h2 className="text-4xl font-bold mb-6">Ready to Start Your Project?</h2>
        <p className="text-xl mb-8 max-w-2xl mx-auto opacity-90">
          Let's work together to create something amazing. Get in touch with our team today and let's discuss your next big idea.
        </p>
        <div className="flex flex-col sm:flex-row gap-4 justify-center">
          <Link to="/contact" className="bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-colors inline-block">
            Get Started Today
          </Link>
          <Link to="/about" className="border-2 border-white text-white px-8 py-4 rounded-xl font-semibold hover:bg-white/10 transition-colors inline-block">
            Learn More About Us
          </Link>
        </div>
      </div>
    </section>
  )
}

export default function Home() {
  return (
    <div className="min-h-screen">
      <Hero />
      <ServicesPreview />
      <AboutPreview />
      <PortfolioPreview />
      <TestimonialsPreview />
      <CTA />
    </div>
  )
}