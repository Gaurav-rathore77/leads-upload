import { Link } from 'react-router-dom'

const CodeIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-8 h-8">
    <path strokeLinecap="round" strokeLinejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
  </svg>
)

export default function Portfolio() {
  const projects = [
    { 
      title: 'E-Commerce Platform', 
      desc: 'Full-stack e-commerce solution with React & Node.js', 
      gradient: 'from-primary-600 to-purple-600',
      category: 'Web Development',
      client: 'RetailCo',
      year: '2024'
    },
    { 
      title: 'Mobile Banking App', 
      desc: 'Secure mobile banking experience for iOS & Android', 
      gradient: 'from-purple-600 to-accent',
      category: 'Mobile App',
      client: 'FinanceBank',
      year: '2024'
    },
    { 
      title: 'Healthcare Dashboard', 
      desc: 'Patient management and analytics platform', 
      gradient: 'from-green-500 to-primary-600',
      category: 'UI/UX Design',
      client: 'HealthPlus',
      year: '2023'
    },
    { 
      title: 'Marketing Automation', 
      desc: 'Complete marketing automation suite with analytics', 
      gradient: 'from-blue-500 to-cyan-500',
      category: 'Web Development',
      client: 'MarketPro',
      year: '2023'
    },
    { 
      title: 'Social Media App', 
      desc: 'Cross-platform social networking application', 
      gradient: 'from-pink-500 to-rose-500',
      category: 'Mobile App',
      client: 'SocialHub',
      year: '2023'
    },
    { 
      title: 'Real Estate Platform', 
      desc: 'Property listing and management system', 
      gradient: 'from-amber-500 to-orange-500',
      category: 'Web Development',
      client: 'PropertyFind',
      year: '2022'
    },
  ]

  const categories = ['All', 'Web Development', 'Mobile App', 'UI/UX Design']

  return (
    <div className="min-h-screen pt-20">
      {/* Hero Section */}
      <section className="section-padding bg-gradient-to-b from-gray-50 to-white">
        <div className="container mx-auto px-6">
          <div className="text-center max-w-3xl mx-auto mb-16">
            <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
              Our Portfolio
            </span>
            <h1 className="text-5xl font-black text-secondary mb-6">
              Featured Projects
            </h1>
            <p className="text-xl text-gray-600">
              Explore our portfolio of successful projects that have helped businesses achieve their digital goals.
            </p>
          </div>

          {/* Filter Buttons */}
          <div className="flex flex-wrap justify-center gap-4 mb-12">
            {categories.map((category) => (
              <button
                key={category}
                className="px-6 py-2 rounded-full border-2 border-primary-600 text-primary-600 font-medium hover:bg-primary-600 hover:text-white transition-colors"
              >
                {category}
              </button>
            ))}
          </div>

          {/* Projects Grid */}
          <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            {projects.map((project, index) => (
              <div key={index} className="card overflow-hidden group">
                <div className={`h-48 bg-gradient-to-br ${project.gradient} flex items-center justify-center`}>
                  <div className="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-transform">
                    <CodeIcon />
                  </div>
                </div>
                <div className="p-6">
                  <div className="flex items-center justify-between mb-2">
                    <span className="text-sm text-primary-600 font-medium">{project.category}</span>
                    <span className="text-sm text-gray-500">{project.year}</span>
                  </div>
                  <h3 className="text-xl font-bold text-secondary mb-2">{project.title}</h3>
                  <p className="text-gray-600 mb-4">{project.desc}</p>
                  <div className="flex items-center justify-between">
                    <span className="text-sm text-gray-500">Client: {project.client}</span>
                    <button className="text-primary-600 font-medium hover:underline">View Details</button>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="section-padding bg-gradient-to-r from-primary-600 to-purple-600 text-white">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6">Ready to Be Our Next Success Story?</h2>
          <p className="text-xl mb-8 max-w-2xl mx-auto opacity-90">
            Let's work together to create something amazing for your business.
          </p>
          <Link to="/contact" className="bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-colors inline-block">
            Start Your Project
          </Link>
        </div>
      </section>
    </div>
  )
}