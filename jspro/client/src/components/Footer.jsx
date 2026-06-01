import { NavLink } from 'react-router-dom'

export default function Footer() {
  return (
    <footer className="bg-secondary text-white py-16">
      <div className="container mx-auto px-6">
        <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
          <div>
            <NavLink to="/" className="flex items-center gap-2 text-2xl font-bold mb-4">
              <div className="w-10 h-10 bg-gradient-to-br from-primary-500 to-purple-500 rounded-lg flex items-center justify-center text-white font-black">
                JS
              </div>
              <span>JSPRO</span>
            </NavLink>
            <p className="text-gray-400 mb-6">
              Transforming ideas into digital excellence. We build beautiful, functional, and scalable digital solutions.
            </p>
            <div className="flex gap-3">
              {['twitter', 'linkedin', 'github', 'instagram'].map((social) => (
                <a key={social} href="#" className="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-primary-600 transition-colors">
                  <span className="sr-only">{social}</span>
                  <svg className="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="4" />
                  </svg>
                </a>
              ))}
            </div>
          </div>
          <div>
            <h4 className="font-semibold mb-4">Services</h4>
            <ul className="space-y-3">
              {['Web Development', 'Mobile Apps', 'UI/UX Design', 'Digital Marketing'].map((item) => (
                <li key={item}>
                  <NavLink to="/services" className="text-gray-400 hover:text-white transition-colors">{item}</NavLink>
                </li>
              ))}
            </ul>
          </div>
          <div>
            <h4 className="font-semibold mb-4">Company</h4>
            <ul className="space-y-3">
              {['About Us', 'Portfolio', 'Testimonials', 'Contact'].map((item) => (
                <li key={item}>
                  <NavLink to={`/${item.toLowerCase().replace(' us', '').replace(' ', '')}`} className="text-gray-400 hover:text-white transition-colors">{item}</NavLink>
                </li>
              ))}
            </ul>
          </div>
          <div>
            <h4 className="font-semibold mb-4">Resources</h4>
            <ul className="space-y-3">
              {['Blog', 'Case Studies', 'Careers', 'Privacy Policy'].map((item) => (
                <li key={item}>
                  <a href="#" className="text-gray-400 hover:text-white transition-colors">{item}</a>
                </li>
              ))}
            </ul>
          </div>
        </div>
        <div className="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-gray-400 text-sm">© 2026 JSPRO Agency. All rights reserved.</p>
          <div className="flex gap-6">
            <a href="#" className="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
            <a href="#" className="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
            <a href="#" className="text-gray-400 hover:text-white text-sm transition-colors">Cookie Policy</a>
          </div>
        </div>
      </div>
    </footer>
  )
}