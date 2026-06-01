import { Link } from 'react-router-dom'

const CheckIcon = () => (
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5 text-green-500">
    <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
  </svg>
)

export default function About() {
  const values = [
    { title: 'Excellence', description: 'We strive for excellence in every project, delivering high-quality solutions that exceed expectations.' },
    { title: 'Innovation', description: 'We stay at the forefront of technology, constantly exploring new tools and methodologies.' },
    { title: 'Integrity', description: 'We believe in transparent communication and honest partnerships with our clients.' },
    { title: 'Collaboration', description: 'We work closely with our clients, treating their success as our own.' },
  ]

  const team = [
    { name: 'Alex Johnson', role: 'Founder & CEO', initials: 'AJ' },
    { name: 'Sarah Chen', role: 'Lead Designer', initials: 'SC' },
    { name: 'Michael Brown', role: 'Tech Lead', initials: 'MB' },
    { name: 'Emily Davis', role: 'Marketing Director', initials: 'ED' },
  ]

  return (
    <div className="min-h-screen pt-20">
      {/* Hero Section */}
      <section className="section-padding bg-gradient-to-b from-gray-50 to-white">
        <div className="container mx-auto px-6">
          <div className="grid lg:grid-cols-2 gap-16 items-center">
            <div>
              <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
                About Us
              </span>
              <h1 className="text-5xl font-black text-secondary mb-6">
                We Build Digital Products That Matter
              </h1>
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

      {/* Values Section */}
      <section className="section-padding bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="text-center max-w-2xl mx-auto mb-16">
            <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
              Our Values
            </span>
            <h2 className="text-4xl font-bold text-secondary mb-4">What Drives Us</h2>
            <p className="text-lg text-gray-600">
              Our core values shape everything we do, from how we work with clients to how we build products.
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {values.map((value, index) => (
              <div key={index} className="card p-8 text-center">
                <div className="w-16 h-16 bg-gradient-to-br from-primary-600 to-purple-600 rounded-xl flex items-center justify-center text-white mx-auto mb-6">
                  <span className="text-2xl font-bold">{index + 1}</span>
                </div>
                <h3 className="text-xl font-bold text-secondary mb-3">{value.title}</h3>
                <p className="text-gray-600">{value.description}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Team Section */}
      <section className="section-padding">
        <div className="container mx-auto px-6">
          <div className="text-center max-w-2xl mx-auto mb-16">
            <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
              Our Team
            </span>
            <h2 className="text-4xl font-bold text-secondary mb-4">Meet the Experts</h2>
            <p className="text-lg text-gray-600">
              Our team brings together diverse skills and perspectives to deliver exceptional results.
            </p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {team.map((member, index) => (
              <div key={index} className="card p-8 text-center">
                <div className="w-24 h-24 bg-gradient-to-br from-primary-600 to-purple-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-6">
                  {member.initials}
                </div>
                <h3 className="text-xl font-bold text-secondary mb-2">{member.name}</h3>
                <p className="text-gray-600">{member.role}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="section-padding bg-gradient-to-r from-primary-600 to-purple-600 text-white">
        <div className="container mx-auto px-6">
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div>
              <div className="text-5xl font-black mb-2">150+</div>
              <div className="text-primary-100">Projects Completed</div>
            </div>
            <div>
              <div className="text-5xl font-black mb-2">50+</div>
              <div className="text-primary-100">Happy Clients</div>
            </div>
            <div>
              <div className="text-5xl font-black mb-2">99%</div>
              <div className="text-primary-100">Client Satisfaction</div>
            </div>
            <div>
              <div className="text-5xl font-black mb-2">24/7</div>
              <div className="text-primary-100">Support Available</div>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="section-padding">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold text-secondary mb-6">Ready to Work Together?</h2>
          <p className="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            Let's discuss how we can help bring your vision to life.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link to="/contact" className="btn btn-primary btn-large">
              Get in Touch
            </Link>
            <Link to="/portfolio" className="btn btn-secondary btn-large">
              View Our Work
            </Link>
          </div>
        </div>
      </section>
    </div>
  )
}