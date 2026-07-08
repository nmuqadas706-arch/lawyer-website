/**
 * data.js — Static mock data for LexConnect Online Lawyers Platform
 * All data is dummy/static; no backend involved.
 */

// ─── Practice Areas ─────────────────────────────────────────────────────────
const PRACTICE_AREAS = [
  { id: "criminal",   label: "Criminal Law",    icon: "fas fa-gavel",         color: "#C0392B" },
  { id: "divorce",    label: "Divorce & Family",icon: "fas fa-heart-broken",  color: "#8E44AD" },
  { id: "affidavit",  label: "Affidavit",       icon: "fas fa-file-signature",color: "#2980B9" },
  { id: "civil",      label: "Civil Law",       icon: "fas fa-balance-scale", color: "#16A085" },
  { id: "property",   label: "Property Law",    icon: "fas fa-home",          color: "#D35400" },
  { id: "corporate",  label: "Corporate Law",   icon: "fas fa-briefcase",     color: "#27AE60" },
  { id: "immigration",label: "Immigration",     icon: "fas fa-passport",      color: "#2C3E50" },
  { id: "tax",        label: "Tax Law",         icon: "fas fa-calculator",    color: "#F39C12" }
];

// ─── Lawyers Data ────────────────────────────────────────────────────────────
const LAWYERS = [
  {
    id: 1,
    name: "Alexandra Harrington",
    specialization: "criminal",
    specializationLabel: "Criminal Law",
    location: "New York, NY",
    experience: 15,
    rating: 4.9,
    reviews: 127,
    price: 350,
    image: "https://randomuser.me/api/portraits/women/44.jpg",
    bio: "Senior criminal defense attorney with 15 years of trial experience. Former assistant district attorney, now championing justice for the accused.",
    education: "Harvard Law School, J.D. 2009",
    barNumber: "NY-2009-7742",
    languages: ["English", "Spanish"],
    wins: 94,
    totalCases: 112,
    featured: true,
    slots: [
      { date: "2026-07-05", times: ["09:00 AM", "11:00 AM", "02:00 PM"] },
      { date: "2026-07-06", times: ["10:00 AM", "03:00 PM"] },
      { date: "2026-07-07", times: ["09:00 AM", "01:00 PM", "04:00 PM"] },
      { date: "2026-07-08", times: ["11:00 AM", "02:00 PM"] },
      { date: "2026-07-09", times: ["09:00 AM", "10:00 AM", "03:00 PM"] }
    ],
    reviews_list: [
      { name: "James T.", rating: 5, comment: "Alexandra saved my career. Brilliant legal mind and truly cares about her clients.", date: "2026-05-14" },
      { name: "Sarah M.", rating: 5, comment: "Exceptional attorney. Clear communication throughout the entire process.", date: "2026-04-22" },
      { name: "Robert K.", rating: 4, comment: "Very professional and thorough. Won our case when all hope seemed lost.", date: "2026-03-10" }
    ]
  },
  {
    id: 2,
    name: "Dr. Marcus Chen",
    specialization: "corporate",
    specializationLabel: "Corporate Law",
    location: "San Francisco, CA",
    experience: 20,
    rating: 4.8,
    reviews: 203,
    price: 500,
    image: "https://randomuser.me/api/portraits/men/32.jpg",
    bio: "Corporate law specialist with dual expertise in mergers & acquisitions and intellectual property. Trusted by Fortune 500 companies.",
    education: "Yale Law School, J.D. 2004",
    barNumber: "CA-2004-3318",
    languages: ["English", "Mandarin", "Japanese"],
    wins: 178,
    totalCases: 201,
    featured: true,
    slots: [
      { date: "2026-07-05", times: ["10:00 AM", "02:00 PM"] },
      { date: "2026-07-07", times: ["09:00 AM", "11:00 AM", "04:00 PM"] },
      { date: "2026-07-08", times: ["10:00 AM", "01:00 PM"] },
      { date: "2026-07-10", times: ["09:00 AM", "03:00 PM", "05:00 PM"] }
    ],
    reviews_list: [
      { name: "TechVentures Inc.", rating: 5, comment: "Dr. Chen handled our Series B documentation flawlessly. Exceptional service.", date: "2026-06-01" },
      { name: "Priya S.", rating: 5, comment: "Best corporate attorney in SF. His attention to detail is unmatched.", date: "2026-05-20" },
      { name: "Alan W.", rating: 4, comment: "Highly knowledgeable and responsive. Will definitely use again.", date: "2026-04-15" }
    ]
  },
  {
    id: 3,
    name: "Isabelle Moreau",
    specialization: "divorce",
    specializationLabel: "Divorce & Family",
    location: "Chicago, IL",
    experience: 12,
    rating: 4.9,
    reviews: 89,
    price: 280,
    image: "https://randomuser.me/api/portraits/women/65.jpg",
    bio: "Compassionate family law attorney specializing in divorce, child custody, and mediation. I guide families through their most difficult moments with dignity.",
    education: "Northwestern University School of Law, J.D. 2012",
    barNumber: "IL-2012-5591",
    languages: ["English", "French"],
    wins: 71,
    totalCases: 85,
    featured: true,
    slots: [
      { date: "2026-07-05", times: ["09:00 AM", "01:00 PM"] },
      { date: "2026-07-06", times: ["10:00 AM", "02:00 PM", "04:00 PM"] },
      { date: "2026-07-08", times: ["09:00 AM", "11:00 AM"] },
      { date: "2026-07-09", times: ["01:00 PM", "03:00 PM"] }
    ],
    reviews_list: [
      { name: "Michelle D.", rating: 5, comment: "Isabelle made an incredibly painful process bearable. She fought hard for me and my children.", date: "2026-06-10" },
      { name: "Thomas B.", rating: 5, comment: "Brilliant lawyer who truly listens. My custody arrangement was settled fairly thanks to her.", date: "2026-05-30" },
      { name: "Karen L.", rating: 5, comment: "Empathetic, professional, and effective. Could not recommend more highly.", date: "2026-04-18" }
    ]
  },
  {
    id: 4,
    name: "Rajesh Patel",
    specialization: "property",
    specializationLabel: "Property Law",
    location: "Houston, TX",
    experience: 18,
    rating: 4.7,
    reviews: 156,
    price: 320,
    image: "https://randomuser.me/api/portraits/men/51.jpg",
    bio: "Property and real estate law expert with extensive experience in commercial transactions, landlord-tenant disputes, and title issues across Texas.",
    education: "University of Texas School of Law, J.D. 2006",
    barNumber: "TX-2006-8821",
    languages: ["English", "Hindi", "Gujarati"],
    wins: 131,
    totalCases: 154,
    featured: false,
    slots: [
      { date: "2026-07-06", times: ["09:00 AM", "11:00 AM", "03:00 PM"] },
      { date: "2026-07-07", times: ["10:00 AM", "02:00 PM"] },
      { date: "2026-07-09", times: ["09:00 AM", "01:00 PM", "04:00 PM"] },
      { date: "2026-07-10", times: ["10:00 AM", "03:00 PM"] }
    ],
    reviews_list: [
      { name: "David R.", rating: 5, comment: "Rajesh saved our property deal from falling apart at the last minute. Incredible expertise.", date: "2026-06-05" },
      { name: "Linda C.", rating: 4, comment: "Very thorough with the title search. Found issues we never would have caught ourselves.", date: "2026-05-14" },
      { name: "Michael H.", rating: 5, comment: "Professional, responsive, and knows Texas property law inside-out.", date: "2026-04-28" }
    ]
  },
  {
    id: 5,
    name: "Elena Vasquez",
    specialization: "immigration",
    specializationLabel: "Immigration",
    location: "Miami, FL",
    experience: 10,
    rating: 4.8,
    reviews: 94,
    price: 250,
    image: "https://randomuser.me/api/portraits/women/28.jpg",
    bio: "Dedicated immigration attorney helping families and professionals navigate the complex U.S. immigration system. Green cards, visas, citizenship — I handle it all.",
    education: "University of Miami School of Law, J.D. 2014",
    barNumber: "FL-2014-2234",
    languages: ["English", "Spanish", "Portuguese"],
    wins: 82,
    totalCases: 92,
    featured: true,
    slots: [
      { date: "2026-07-05", times: ["09:00 AM", "11:00 AM", "02:00 PM", "04:00 PM"] },
      { date: "2026-07-07", times: ["10:00 AM", "01:00 PM"] },
      { date: "2026-07-08", times: ["09:00 AM", "03:00 PM"] },
      { date: "2026-07-09", times: ["11:00 AM", "02:00 PM", "05:00 PM"] }
    ],
    reviews_list: [
      { name: "Carlos M.", rating: 5, comment: "Elena got my green card approved after two previous rejections. She is a miracle worker!", date: "2026-06-15" },
      { name: "Aisha K.", rating: 5, comment: "Extremely knowledgeable and supportive throughout the H-1B process. Highly recommend.", date: "2026-05-22" },
      { name: "Yuki T.", rating: 4, comment: "Clear, honest communication. She set realistic expectations and delivered results.", date: "2026-04-30" }
    ]
  },
  {
    id: 6,
    name: "William O'Brien",
    specialization: "civil",
    specializationLabel: "Civil Law",
    location: "Boston, MA",
    experience: 22,
    rating: 4.6,
    reviews: 211,
    price: 400,
    image: "https://randomuser.me/api/portraits/men/78.jpg",
    bio: "Veteran civil litigation attorney with over two decades of courtroom experience. Personal injury, contracts, and civil rights — I fight for what's right.",
    education: "Boston College Law School, J.D. 2002",
    barNumber: "MA-2002-1145",
    languages: ["English"],
    wins: 189,
    totalCases: 209,
    featured: false,
    slots: [
      { date: "2026-07-06", times: ["10:00 AM", "02:00 PM"] },
      { date: "2026-07-07", times: ["09:00 AM", "11:00 AM", "03:00 PM"] },
      { date: "2026-07-08", times: ["01:00 PM", "04:00 PM"] },
      { date: "2026-07-10", times: ["09:00 AM", "10:00 AM", "02:00 PM"] }
    ],
    reviews_list: [
      { name: "Nancy P.", rating: 5, comment: "William is a legend in civil litigation. Won my personal injury case with a record settlement.", date: "2026-06-08" },
      { name: "George A.", rating: 4, comment: "Experienced, smart, and knows how to navigate the courts. Very satisfied.", date: "2026-05-10" },
      { name: "Patricia L.", rating: 5, comment: "Outstanding attorney. Got us justice when no one else would take the case.", date: "2026-04-05" }
    ]
  },
  {
    id: 7,
    name: "Zara Okonkwo",
    specialization: "affidavit",
    specializationLabel: "Affidavit & Documentation",
    location: "Atlanta, GA",
    experience: 8,
    rating: 4.7,
    reviews: 63,
    price: 180,
    image: "https://randomuser.me/api/portraits/women/55.jpg",
    bio: "Specializing in legal documentation, affidavits, notarization, and contract drafting. Fast, accurate, and affordable legal documentation services.",
    education: "Emory University School of Law, J.D. 2016",
    barNumber: "GA-2016-6672",
    languages: ["English", "Igbo"],
    wins: 60,
    totalCases: 63,
    featured: false,
    slots: [
      { date: "2026-07-05", times: ["09:00 AM", "10:00 AM", "11:00 AM", "02:00 PM", "03:00 PM"] },
      { date: "2026-07-06", times: ["09:00 AM", "01:00 PM", "04:00 PM"] },
      { date: "2026-07-07", times: ["10:00 AM", "02:00 PM", "05:00 PM"] },
      { date: "2026-07-09", times: ["09:00 AM", "11:00 AM", "03:00 PM"] }
    ],
    reviews_list: [
      { name: "Marcus E.", rating: 5, comment: "Quick, professional, and affordable. Got my affidavit done in one day!", date: "2026-06-20" },
      { name: "Blessing O.", rating: 4, comment: "Very efficient service. Zara knows her documentation inside out.", date: "2026-05-28" },
      { name: "Todd S.", rating: 5, comment: "Excellent service. Documents were perfect and delivered on time.", date: "2026-04-12" }
    ]
  },
  {
    id: 8,
    name: "Nathan Goldberg",
    specialization: "tax",
    specializationLabel: "Tax Law",
    location: "Los Angeles, CA",
    experience: 16,
    rating: 4.8,
    reviews: 142,
    price: 450,
    image: "https://randomuser.me/api/portraits/men/23.jpg",
    bio: "Tax attorney and CPA with expertise in IRS disputes, international tax planning, and business tax strategy. I protect your wealth legally.",
    education: "UCLA School of Law, J.D. & LLM Tax 2008",
    barNumber: "CA-2008-9901",
    languages: ["English", "Hebrew"],
    wins: 129,
    totalCases: 141,
    featured: true,
    slots: [
      { date: "2026-07-05", times: ["10:00 AM", "01:00 PM"] },
      { date: "2026-07-06", times: ["09:00 AM", "02:00 PM", "04:00 PM"] },
      { date: "2026-07-08", times: ["10:00 AM", "03:00 PM"] },
      { date: "2026-07-10", times: ["09:00 AM", "11:00 AM", "02:00 PM"] }
    ],
    reviews_list: [
      { name: "Corporate Client A", rating: 5, comment: "Nathan saved us millions in tax exposure. Worth every penny.", date: "2026-06-12" },
      { name: "Rachel G.", rating: 5, comment: "Resolved my IRS audit quickly and professionally. Brilliant attorney.", date: "2026-05-18" },
      { name: "Steven R.", rating: 4, comment: "Deep knowledge of tax law. Clear explanations and great results.", date: "2026-04-25" }
    ]
  }
];

// ─── Testimonials ─────────────────────────────────────────────────────────────
const TESTIMONIALS = [
  {
    name: "Jennifer Walsh",
    role: "Business Owner",
    image: "https://randomuser.me/api/portraits/women/33.jpg",
    rating: 5,
    comment: "LexConnect changed everything for me. I found the perfect corporate attorney within minutes and had my business contracts sorted in days. Absolutely seamless experience.",
    location: "New York, NY"
  },
  {
    name: "Michael Torres",
    role: "Software Engineer",
    image: "https://randomuser.me/api/portraits/men/45.jpg",
    rating: 5,
    comment: "I was facing immigration issues and felt completely lost. Within 24 hours of signing up on LexConnect, I had a consultation booked with Elena. She got my visa sorted.",
    location: "San Jose, CA"
  },
  {
    name: "Amara Johnson",
    role: "Real Estate Agent",
    image: "https://randomuser.me/api/portraits/women/71.jpg",
    rating: 5,
    comment: "The property law section is fantastic. I recommend LexConnect to all my clients now. Quick, reliable, and the lawyers are genuinely top-tier.",
    location: "Dallas, TX"
  },
  {
    name: "David Kim",
    role: "Startup Founder",
    image: "https://randomuser.me/api/portraits/men/62.jpg",
    rating: 4,
    comment: "Found an excellent corporate lawyer for our startup's IP issues. The booking system is smooth, the interface is beautiful, and everything just works.",
    location: "Austin, TX"
  },
  {
    name: "Sophia Laurent",
    role: "Freelance Designer",
    image: "https://randomuser.me/api/portraits/women/19.jpg",
    rating: 5,
    comment: "I needed an affidavit for an international client and had no idea where to start. LexConnect connected me with Zara who handled everything perfectly.",
    location: "Chicago, IL"
  }
];

// ─── Dummy Appointments (for Lawyer Dashboard) ────────────────────────────────
const DUMMY_APPOINTMENTS = [
  { id: "APT-001", client: "Jennifer Walsh",    service: "Corporate Consultation", date: "2026-07-05", time: "10:00 AM", status: "confirmed" },
  { id: "APT-002", client: "Michael Torres",    service: "Contract Review",        date: "2026-07-05", time: "02:00 PM", status: "pending"   },
  { id: "APT-003", client: "Robert Adams",      service: "Corporate Consultation", date: "2026-07-06", time: "09:00 AM", status: "confirmed" },
  { id: "APT-004", client: "Amara Johnson",     service: "NDA Drafting",           date: "2026-07-07", time: "11:00 AM", status: "confirmed" },
  { id: "APT-005", client: "Priya Sharma",      service: "Business Formation",     date: "2026-07-08", time: "01:00 PM", status: "pending"   },
  { id: "APT-006", client: "Thomas Wright",     service: "Corporate Consultation", date: "2026-07-09", time: "03:00 PM", status: "cancelled" },
  { id: "APT-007", client: "Cassandra Hill",    service: "IP Consultation",        date: "2026-07-10", time: "10:00 AM", status: "confirmed" }
];

// ─── Admin Data ───────────────────────────────────────────────────────────────
const ADMIN_LAWYERS = [
  { id: "L-001", name: "Alexandra Harrington", specialization: "Criminal Law",    location: "New York, NY",    status: "active",   joined: "2024-01-15" },
  { id: "L-002", name: "Dr. Marcus Chen",       specialization: "Corporate Law",   location: "San Francisco, CA",status: "active",  joined: "2023-11-20" },
  { id: "L-003", name: "Isabelle Moreau",       specialization: "Divorce & Family",location: "Chicago, IL",     status: "active",   joined: "2024-03-08" },
  { id: "L-004", name: "Rajesh Patel",          specialization: "Property Law",    location: "Houston, TX",     status: "active",   joined: "2023-09-14" },
  { id: "L-005", name: "Elena Vasquez",         specialization: "Immigration",     location: "Miami, FL",       status: "pending",  joined: "2026-06-28" },
  { id: "L-006", name: "William O'Brien",       specialization: "Civil Law",       location: "Boston, MA",      status: "active",   joined: "2023-07-22" },
  { id: "L-007", name: "Zara Okonkwo",          specialization: "Affidavit",       location: "Atlanta, GA",     status: "active",   joined: "2024-05-30" },
  { id: "L-008", name: "Nathan Goldberg",       specialization: "Tax Law",         location: "Los Angeles, CA", status: "suspended",joined: "2023-12-01" }
];

const ADMIN_CUSTOMERS = [
  { id: "C-001", name: "Jennifer Walsh",  email: "jennifer@example.com", joined: "2026-01-10", bookings: 3, status: "active" },
  { id: "C-002", name: "Michael Torres", email: "michael@example.com",  joined: "2026-02-14", bookings: 1, status: "active" },
  { id: "C-003", name: "Amara Johnson",  email: "amara@example.com",    joined: "2026-03-22", bookings: 5, status: "active" },
  { id: "C-004", name: "David Kim",      email: "david@example.com",    joined: "2026-04-05", bookings: 2, status: "active" },
  { id: "C-005", name: "Sophia Laurent", email: "sophia@example.com",   joined: "2026-05-18", bookings: 1, status: "active" },
  { id: "C-006", name: "Thomas Wright",  email: "thomas@example.com",   joined: "2026-06-01", bookings: 0, status: "inactive" }
];

const ADMIN_APPOINTMENTS = [
  { id: "APT-001", lawyer: "Dr. Marcus Chen",       client: "Jennifer Walsh",  service: "Corporate Consultation", date: "2026-07-05", status: "confirmed" },
  { id: "APT-002", lawyer: "Elena Vasquez",          client: "Michael Torres",  service: "Visa Consultation",      date: "2026-07-05", status: "pending"   },
  { id: "APT-003", lawyer: "Alexandra Harrington",   client: "Amara Johnson",   service: "Criminal Defense",       date: "2026-07-06", status: "confirmed" },
  { id: "APT-004", lawyer: "Rajesh Patel",           client: "David Kim",       service: "Property Review",        date: "2026-07-07", status: "confirmed" },
  { id: "APT-005", lawyer: "Zara Okonkwo",           client: "Sophia Laurent",  service: "Affidavit Preparation",  date: "2026-07-07", status: "completed" },
  { id: "APT-006", lawyer: "Isabelle Moreau",        client: "Thomas Wright",   service: "Divorce Consultation",   date: "2026-07-08", status: "cancelled" },
  { id: "APT-007", lawyer: "Nathan Goldberg",        client: "Jennifer Walsh",  service: "Tax Planning",           date: "2026-07-09", status: "pending"   },
  { id: "APT-008", lawyer: "William O'Brien",        client: "Amara Johnson",   service: "Civil Case Review",      date: "2026-07-10", status: "confirmed" }
];

// ─── Stats (admin dashboard) ──────────────────────────────────────────────────
const ADMIN_STATS = {
  totalLawyers: 8,
  totalCustomers: 6,
  totalBookings: 8,
  pendingApprovals: 1,
  revenue: 12450,
  avgRating: 4.78
};
