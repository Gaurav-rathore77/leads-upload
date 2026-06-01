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

export default function Services() {
  const services = [
    { icon: <CodeIcon />, title: 'Web Development', description: 'Custom websites and web applications built with modern technologies like React, Node.js, and cloud infrastructure.', features: ['Custom Web Applications', 'E-commerce Solutions', 'CMS Development', 'API Development', 'Performance Optimization'] },
    { icon: <MobileIcon />, title: 'Mobile Apps', description: 'Native and cross-platform mobile applications for iOS and Android that deliver exceptional user experiences.', features: ['iOS Development', 'Android Development', 'Cross-platform Apps', 'App Store Optimization', 'Mobile UI/UX'] },
    { icon: <DesignIcon />, title: 'UI/UX Design', description: 'Beautiful, intuitive designs that enhance user experience and drive engagement across all digital touchpoints.', features: ['User Research', 'Wireframing & Prototyping', 'Visual Design', 'Design Systems', 'Usability Testing'] },
    { icon: <MarketingIcon />, title: 'Digital Marketing', description: 'Strategic marketing solutions including SEO, PPC, social media, and content marketing to grow your online presence.', features: ['SEO Optimization', 'PPC Campaigns', 'Social Media Marketing', 'Content Strategy', 'Analytics & Reporting'] },
    { icon: <CloudIcon />, title: 'Cloud Solutions', description: 'Scalable cloud infrastructure, deployment, and management services on AWS, Google Cloud, and Azure platforms.', features: ['Cloud Migration', 'Infrastructure Setup', 'DevOps Services', 'Managed Services', 'Cost Optimization'] },
    { icon: <ConsultingIcon />, title: 'Consulting', description: 'Expert technical consulting for digital transformation, architecture review, and technology strategy planning.', features: ['Digital Strategy', 'Architecture Review', 'Technology Selection', 'Project Management', 'Team Training'] },
  ]

  return (
    <div className="min-h-screen pt-20">
      {/* Hero Section */}
      <section className="section-padding bg-gradient-to-b from-gray-50 to-white">
        <div className="container mx-auto px-6">
          <div className="text-center max-w-3xl mx-auto mb-16">
            <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
              Our Services
            </span>
            <h1 className="text-5xl font-black text-secondary mb-6">
              Comprehensive Digital Solutions
            </h1>
            <p className="text-xl text-gray-600">
              We offer a full range of digital services to help your business thrive in the modern digital landscape. From concept to execution, we've got you covered.
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {services.map((service, index) => (
              <div key={index} className="card p-8 group">
                <div className="w-16 h-16 bg-gradient-to-br from-primary-600 to-purple-600 rounded-xl flex items-center justify-center text-white mb-6 group-hover:scale-110 transition-transform">
                  {service.icon}
                </div>
                <h3 className="text-xl font-bold text-secondary mb-3">{service.title}</h3>
                <p className="text-gray-600 mb-6">{service.description}</p>
                <ul className="space-y-2">
                  {service.features.map((feature, idx) => (
                    <li key={idx} className="flex items-center gap-2 text-gray-600">
                      <svg className="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                      </svg>
                      {feature}
                    </li>
                  ))}
                </ul>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="section-padding bg-gradient-to-r from-primary-600 to-purple-600 text-white">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6">Ready to Get Started?</h2>
          <p className="text-xl mb-8 max-w-2xl mx-auto opacity-90">
            Let's discuss how we can help bring your vision to life with our expert services.
          </p>
          <Link to="/contact" className="bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-colors inline-block">
            Contact Us Today
          </Link>
        </div>
      </section>
    </div>
  )
}