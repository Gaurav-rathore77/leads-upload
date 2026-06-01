import { Link } from 'react-router-dom'

const StarIcon = () => (
  <svg viewBox="0 0 20 20" className="w-5 h-5 text-yellow-400 fill-current">
    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
  </svg>
)

export default function Testimonials() {
  const testimonials = [
    {
      text: "JSPRO transformed our online presence completely. Their team delivered a stunning website that exceeded our expectations and helped us increase conversions by 200%.",
      author: "John Doe",
      role: "CEO, TechStart Inc.",
      initials: "JD",
      project: "E-commerce Website"
    },
    {
      text: "Working with JSPRO was a game-changer for our business. They built a custom mobile app that our customers love, and their support has been exceptional throughout.",
      author: "Sarah Mitchell",
      role: "Founder, HealthPlus",
      initials: "SM",
      project: "Mobile App Development"
    },
    {
      text: "The team at JSPRO is incredibly skilled and professional. They delivered our project on time and within budget, and the results have been outstanding.",
      author: "Michael Roberts",
      role: "CTO, FinanceFlow",
      initials: "MR",
      project: "Financial Dashboard"
    },
    {
      text: "We've worked with many agencies before, but JSPRO stands out for their attention to detail and commitment to quality. Highly recommended!",
      author: "Emily Chen",
      role: "Marketing Director, GrowthCo",
      initials: "EC",
      project: "Digital Marketing Campaign"
    },
    {
      text: "The UI/UX design work they did for our platform was exceptional. Our users love the new interface and engagement has increased significantly.",
      author: "David Kim",
      role: "Product Manager, InnovateTech",
      initials: "DK",
      project: "UI/UX Redesign"
    },
    {
      text: "Professional, responsive, and results-driven. JSPRO helped us migrate to the cloud and the performance improvements have been remarkable.",
      author: "Lisa Anderson",
      role: "IT Director, CloudFirst",
      initials: "LA",
      project: "Cloud Migration"
    }
  ]

  return (
    <div className="min-h-screen pt-20">
      {/* Hero Section */}
      <section className="section-padding bg-gradient-to-b from-gray-50 to-white">
        <div className="container mx-auto px-6">
          <div className="text-center max-w-3xl mx-auto mb-16">
            <span className="inline-block px-4 py-2 bg-primary-100 text-primary-600 rounded-full text-sm font-semibold mb-4">
              Testimonials
            </span>
            <h1 className="text-5xl font-black text-secondary mb-6">
              What Our Clients Say
            </h1>
            <p className="text-xl text-gray-600">
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
                <div className="flex items-center gap-4 mb-4">
                  <div className="w-12 h-12 bg-gradient-to-br from-primary-600 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                    {testimonial.initials}
                  </div>
                  <div>
                    <div className="font-semibold text-secondary">{testimonial.author}</div>
                    <div className="text-sm text-gray-500">{testimonial.role}</div>
                  </div>
                </div>
                <div className="pt-4 border-t border-gray-200">
                  <span className="text-sm text-primary-600 font-medium">Project: {testimonial.project}</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* Stats Section */}
      <section className="section-padding bg-gray-50">
        <div className="container mx-auto px-6">
          <div className="text-center max-w-2xl mx-auto mb-12">
            <h2 className="text-3xl font-bold text-secondary mb-4">Trusted by Businesses Worldwide</h2>
            <p className="text-lg text-gray-600">
              Our commitment to excellence has earned us the trust of clients across industries.
            </p>
          </div>
          <div className="grid md:grid-cols-3 gap-8 text-center">
            <div className="card p-6">
              <div className="text-4xl font-black text-primary-600 mb-2">50+</div>
              <div className="text-gray-600">Happy Clients</div>
            </div>
            <div className="card p-6">
              <div className="text-4xl font-black text-primary-600 mb-2">150+</div>
              <div className="text-gray-600">Projects Delivered</div>
            </div>
            <div className="card p-6">
              <div className="text-4xl font-black text-primary-600 mb-2">99%</div>
              <div className="text-gray-600">Client Satisfaction</div>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="section-padding bg-gradient-to-r from-primary-600 to-purple-600 text-white">
        <div className="container mx-auto px-6 text-center">
          <h2 className="text-4xl font-bold mb-6">Ready to Join Our Happy Clients?</h2>
          <p className="text-xl mb-8 max-w-2xl mx-auto opacity-90">
            Let's create something amazing together. Get in touch with our team today.
          </p>
          <Link to="/contact" className="bg-white text-primary-600 px-8 py-4 rounded-xl font-semibold hover:bg-gray-100 transition-colors inline-block">
            Start Your Project
          </Link>
        </div>
      </section>
    </div>
  )
}