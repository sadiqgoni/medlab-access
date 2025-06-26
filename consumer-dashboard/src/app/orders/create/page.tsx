"use client"

import type React from "react"
import { useEffect, useState } from "react"
import Link from "next/link"
import { 
  ClockIcon, 
  CheckCircleIcon,
  BeakerIcon,
  HeartIcon,
  UserIcon,
  PlusIcon,
  BoltIcon,
  ChevronDownIcon,
  ClipboardDocumentListIcon,
  DocumentCheckIcon,
  CalendarDaysIcon,
  ArrowTrendingUpIcon,
  SparklesIcon,
  ChartBarIcon,
  EyeIcon,
  MapPinIcon,
  BuildingOffice2Icon,
  GlobeAltIcon,
  MagnifyingGlassIcon,
  FunnelIcon,
  XMarkIcon,
  MapIcon,
  StarIcon,
  PhoneIcon,
  ChevronRightIcon,
  ArrowLeftIcon,
  ShieldExclamationIcon,
  ScaleIcon,
  ShoppingCartIcon,
} from "@heroicons/react/24/outline"


// Mock data for demonstration
const mockOrders = [
  {
    id: 1,
    test_type: 'Complete Blood Count (CBC)',
    type: 'test',
    status: 'completed',
    facility_name: 'HealthLab Central',
    created_at: '2024-01-15T10:30:00Z',
    scheduled_date: '2024-01-16T09:00:00Z',
    total_amount: 89.99,
    payment_status: 'paid',
    results_ready: true,
    results_url: '/results/1'
  },
  {
    id: 2,
    test_type: 'Blood Donation',
    type: 'blood',
    status: 'in_progress',
    facility_name: 'City Blood Bank',
    created_at: '2024-01-14T14:20:00Z',
    scheduled_date: '2024-01-17T11:00:00Z',
    total_amount: 0,
    payment_status: 'paid',
    results_ready: false,
    results_url: null
  },
  {
    id: 3,
    test_type: 'Lipid Panel',
    type: 'test',
    status: 'pending',
    facility_name: 'MedTest Pro',
    created_at: '2024-01-13T16:45:00Z',
    scheduled_date: '2024-01-18T08:30:00Z',
    total_amount: 125.50,
    payment_status: 'pending',
    results_ready: false,
    results_url: null
  }
];

interface MedicalCenter {
  id: string;
  name: string;
  address: string;
  distance: string;
  city: string;
  state: string;
  rating: number;
  reviewCount: number;
  phone: string;
  openingHours: {
    open: string;
    close: string;
    isOpen: boolean;
  };
  services: string[];
  verified: boolean;
  image: string;
  priceRange: 'budget' | 'mid' | 'premium';
  type: 'hospital' | 'clinic' | 'laboratory' | 'diagnostic_center';
}

interface TestCategory {
  id: string;
  name: string;
  description: string;
  testCount: number;
  priceRange: string;
  icon: string;
  tests: Test[];
}

interface Test {
  id: string;
  name: string;
  description: string;
  price: number;
  preparationTime: string;
  resultTime: string;
  fasting: boolean;
  category: string;
  lab: string;
  specimen: string;
  averageProcessingTime: string;
  specialInstructions: string;
  collectionInstructions: string;
  additionalInformation: string;
  detailedDescription: string;
  alternateName?: string;
}

const allMedicalCenters: MedicalCenter[] = [
  {
    id: '1',
    name: 'Lagos Medical Center',
    address: '15 Ademola Street, Victoria Island, Lagos',
    distance: '1.2 km',
    city: 'Lagos',
    state: 'Lagos',
    rating: 4.8,
    reviewCount: 324,
    phone: '+234 1 234 5678',
    openingHours: { open: '7:00 AM', close: '9:00 PM', isOpen: true },
    services: ['Blood Tests', 'Radiology', 'Cardiology', 'General Health'],
    verified: true,
    image: '/images/lagos-medical.jpg',
    priceRange: 'premium',
    type: 'hospital'
  },
  {
    id: '2',
    name: 'HealthPlus Diagnostic',
    address: '23 Broad Street, Lagos Island, Lagos',
    distance: '2.8 km',
    city: 'Lagos',
    state: 'Lagos',
    rating: 4.6,
    reviewCount: 189,
    phone: '+234 1 345 6789',
    openingHours: { open: '6:00 AM', close: '10:00 PM', isOpen: true },
    services: ['Lab Tests', 'Pregnancy Tests', 'STD Screening'],
    verified: true,
    image: '/images/healthplus.jpg',
    priceRange: 'mid',
    type: 'diagnostic_center'
  },
  {
    id: '3',
    name: 'Iwosan Medical Laboratory',
    address: '45 Ikorodu Road, Palmgrove, Lagos',
    distance: '4.1 km',
    city: 'Lagos',
    state: 'Lagos',
    rating: 4.4,
    reviewCount: 156,
    phone: '+234 1 456 7890',
    openingHours: { open: '8:00 AM', close: '6:00 PM', isOpen: false },
    services: ['Blood Bank', 'Molecular Tests', 'Microbiology'],
    verified: true,
    image: '/images/iwosan-lab.jpg',
    priceRange: 'budget',
    type: 'laboratory'
  },
  {
    id: '4',
    name: 'Clina-Lancet Laboratories',
    address: '12 Kofo Abayomi Street, Victoria Island, Lagos',
    distance: '1.8 km',
    city: 'Lagos',
    state: 'Lagos',
    rating: 4.9,
    reviewCount: 267,
    phone: '+234 1 567 8901',
    openingHours: { open: '24 Hours', close: '24 Hours', isOpen: true },
    services: ['Emergency Lab', 'Forensic Tests', 'Specialized Diagnostics'],
    verified: true,
    image: '/images/clina-lancet.jpg',
    priceRange: 'premium',
    type: 'laboratory'
  },
  // Abuja Centers
  {
    id: '5',
    name: 'Federal Medical Centre Abuja',
    address: 'Jabi District, Abuja FCT',
    distance: 'N/A',
    city: 'Abuja',
    state: 'FCT',
    rating: 4.7,
    reviewCount: 412,
    phone: '+234 9 234 5678',
    openingHours: { open: '24 Hours', close: '24 Hours', isOpen: true },
    services: ['Emergency Care', 'Blood Tests', 'Radiology', 'Surgery'],
    verified: true,
    image: '/images/fmc-abuja.jpg',
    priceRange: 'mid',
    type: 'hospital'
  },
  {
    id: '6',
    name: 'Cedarcrest Hospitals',
    address: 'Gudu District, Abuja FCT',
    distance: 'N/A',
    city: 'Abuja',
    state: 'FCT',
    rating: 4.5,
    reviewCount: 298,
    phone: '+234 9 345 6789',
    openingHours: { open: '7:00 AM', close: '9:00 PM', isOpen: true },
    services: ['Maternity', 'Pediatrics', 'Lab Tests', 'General Health'],
    verified: true,
    image: '/images/cedarcrest.jpg',
    priceRange: 'premium',
    type: 'hospital'
  },
  {
    id: '7',
    name: 'Synlab Nigeria Abuja',
    address: 'Wuse 2, Abuja FCT',
    distance: 'N/A',
    city: 'Abuja',
    state: 'FCT',
    rating: 4.6,
    reviewCount: 156,
    phone: '+234 9 456 7890',
    openingHours: { open: '6:00 AM', close: '8:00 PM', isOpen: true },
    services: ['Laboratory Tests', 'Pathology', 'Molecular Diagnostics'],
    verified: true,
    image: '/images/synlab-abuja.jpg',
    priceRange: 'premium',
    type: 'laboratory'
  },
  // Kano Centers
  {
    id: '8',
    name: 'Aminu Kano Teaching Hospital',
    address: 'Zaria Road, Kano State',
    distance: 'N/A',
    city: 'Kano',
    state: 'Kano',
    rating: 4.3,
    reviewCount: 234,
    phone: '+234 64 234 567',
    openingHours: { open: '24 Hours', close: '24 Hours', isOpen: true },
    services: ['Emergency Care', 'Surgery', 'Blood Bank', 'Lab Tests'],
    verified: true,
    image: '/images/akth.jpg',
    priceRange: 'budget',
    type: 'hospital'
  },
  {
    id: '9',
    name: 'Malam Aminu Kano Hospital',
    address: 'Kofar Mazugal, Kano State',
    distance: 'N/A',
    city: 'Kano',
    state: 'Kano',
    rating: 4.2,
    reviewCount: 189,
    phone: '+234 64 345 678',
    openingHours: { open: '7:00 AM', close: '7:00 PM', isOpen: true },
    services: ['General Medicine', 'Pediatrics', 'Lab Tests'],
    verified: true,
    image: '/images/mak-hospital.jpg',
    priceRange: 'budget',
    type: 'hospital'
  },
  {
    id: '10',
    name: 'Kano Diagnostic Centre',
    address: 'Sabon Gari, Kano State',
    distance: 'N/A',
    city: 'Kano',
    state: 'Kano',
    rating: 4.1,
    reviewCount: 145,
    phone: '+234 64 456 789',
    openingHours: { open: '8:00 AM', close: '6:00 PM', isOpen: false },
    services: ['X-Ray', 'Ultrasound', 'Blood Tests', 'ECG'],
    verified: true,
    image: '/images/kano-diagnostic.jpg',
    priceRange: 'mid',
    type: 'diagnostic_center'
  }
];

const testCategories: TestCategory[] = [
  {
    id: 'blood',
    name: 'Blood Tests',
    description: 'Comprehensive blood analysis and screening',
    testCount: 15,
    priceRange: '₦5,000 - ₦25,000',
    icon: 'BeakerIcon',
    tests: [
      {
        id: 'fbc',
        name: 'Full Blood Count (FBC)',
        description: 'Complete blood cell analysis including red blood cells, white blood cells, and platelets',
        price: 8000,
        preparationTime: 'No special preparation needed',
        resultTime: '24 hours',
        fasting: false,
        category: 'blood',
        lab: 'Quest Diagnostics',
        specimen: 'Blood, Serum',
        averageProcessingTime: '1-2 days',
        specialInstructions: 'None required',
        collectionInstructions: 'Standard blood draw from arm vein. No special collection requirements.',
        additionalInformation: 'This test provides a comprehensive overview of your overall health and can help detect infections, anemia, and blood disorders.',
        detailedDescription: 'A Full Blood Count is one of the most commonly ordered blood tests. It measures different components of your blood including red blood cells (which carry oxygen), white blood cells (which fight infection), and platelets (which help blood clot). This test can help diagnose conditions like anemia, infections, and blood disorders.',
        alternateName: 'Complete Blood Count (CBC)'
      },
      {
        id: 'lipid',
        name: 'Lipid Profile',
        description: 'Cholesterol and triglyceride levels assessment',
        price: 12000,
        preparationTime: '12-hour fasting required',
        resultTime: '24 hours',
        fasting: true,
        category: 'blood',
        lab: 'Quest Diagnostics',
        specimen: 'Blood, Serum',
        averageProcessingTime: '1-2 days',
        specialInstructions: 'Fast for 12 hours before test. Water is allowed.',
        collectionInstructions: 'Blood sample collected after 12-hour fasting period. Last meal should be at least 12 hours before collection.',
        additionalInformation: 'This test helps assess cardiovascular disease risk. Results may be affected by recent illness, pregnancy, or certain medications.',
        detailedDescription: 'A lipid profile measures the amount of cholesterol and triglycerides in your blood. High levels of cholesterol and triglycerides can increase your risk of heart disease and stroke. The test includes total cholesterol, LDL (bad) cholesterol, HDL (good) cholesterol, and triglycerides.',
        alternateName: 'Cholesterol Panel'
      }
    ]
  },
  {
    id: 'allergy',
    name: 'Allergy Tests',
    description: 'Food and environmental allergy screening',
    testCount: 8,
    priceRange: '₦10,000 - ₦40,000',
    icon: 'ShieldExclamationIcon',
    tests: [
      {
        id: 'food-allergy',
        name: 'Food Allergy Panel',
        description: 'Test for common food allergies including nuts, dairy, and gluten',
        price: 25000,
        preparationTime: 'Avoid antihistamines 72 hours before test',
        resultTime: '3-5 days',
        fasting: false,
        category: 'allergy',
        lab: 'Quest Diagnostics',
        specimen: 'Blood, Serum',
        averageProcessingTime: 'Average processing time 3-5 days',
        specialInstructions: 'Avoid antihistamines 72 hours before test. Times are an estimate and are not guaranteed. Results may be delayed due to weather, holidays, confirmation/repeat testing, or equipment maintenance.',
        collectionInstructions: 'Standard blood draw from arm vein. No special collection requirements.',
        additionalInformation: 'Exercise within 24 hours, infection, fever, congestive heart failure, marked hyperglycemia, and marked hypertension may affect test results. This panel tests for IgE antibodies to common food allergens.',
        detailedDescription: 'A comprehensive food allergy panel that tests for specific IgE antibodies to common food allergens including nuts (peanuts, tree nuts), dairy products (milk, cheese), wheat/gluten, eggs, shellfish, and other common allergens. This test helps identify foods that may trigger allergic reactions ranging from mild symptoms to severe anaphylaxis.',
        alternateName: 'Food-Specific IgE Panel'
      }
    ]
  },
  {
    id: 'heart',
    name: 'Heart Health',
    description: 'Cardiovascular health assessment',
    testCount: 6,
    priceRange: '₦8,000 - ₦30,000',
    icon: 'HeartIcon',
    tests: [
      {
        id: 'ecg',
        name: 'Electrocardiogram (ECG)',
        description: 'Heart rhythm and electrical activity monitoring',
        price: 15000,
        preparationTime: 'Wear comfortable clothing',
        resultTime: 'Immediate results',
        fasting: false,
        category: 'heart',
        lab: 'Quest Diagnostics',
        specimen: 'Electrocardiogram',
        averageProcessingTime: 'Immediate results',
        specialInstructions: 'Wear comfortable, loose-fitting clothing. Avoid lotions or oils on chest.',
        collectionInstructions: 'Electrodes will be placed on chest, arms, and legs to record heart activity.',
        additionalInformation: 'This test records the electrical activity of your heart and can detect irregular heartbeats, heart attacks, and other heart problems.',
        detailedDescription: 'An electrocardiogram is a painless test that records the electrical activity of your heart. It shows how fast your heart is beating and whether its rhythm is steady or irregular. It also records the strength and timing of electrical signals as they pass through your heart.',
        alternateName: 'EKG'
      }
    ]
  },
  {
    id: 'hormones',
    name: 'Hormone Tests',
    description: 'Thyroid, reproductive, and stress hormones',
    testCount: 12,
    priceRange: '₦10,000 - ₦50,000',
    icon: 'ScaleIcon',
    tests: [
      {
        id: 'thyroid',
        name: 'Thyroid Function Test',
        description: 'TSH, T3, and T4 hormone levels assessment',
        price: 18000,
        preparationTime: 'Morning collection preferred',
        resultTime: '2-3 days',
        fasting: false,
        category: 'hormones',
        lab: 'Quest Diagnostics',
        specimen: 'Blood, Serum',
        averageProcessingTime: '2-3 days',
        specialInstructions: 'Morning collection preferred. Inform lab of any thyroid medications.',
        collectionInstructions: 'Standard blood draw from arm vein. Morning collection is preferred for accurate results.',
        additionalInformation: 'Thyroid function may be affected by recent illness, pregnancy, certain medications, or stress.',
        detailedDescription: 'Thyroid function tests measure hormones produced by the thyroid gland including TSH (thyroid stimulating hormone), T3 (triiodothyronine), and T4 (thyroxine). These hormones regulate metabolism, energy levels, and overall body function.',
        alternateName: 'TFT'
      }
    ]
  }
];

export default function NewOrderPage() {
  const [step, setStep] = useState<'centers' | 'services' | 'categories' | 'tests' | 'cart'>('centers');
  const [selectedCenter, setSelectedCenter] = useState<MedicalCenter | null>(null);
  const [selectedCategory, setSelectedCategory] = useState<TestCategory | null>(null);
  const [cart, setCart] = useState<Test[]>([]);
  const [searchQuery, setSearchQuery] = useState('');
  const [serviceSearchQuery, setServiceSearchQuery] = useState('');
  const [showTestModal, setShowTestModal] = useState(false);
  const [selectedTestForModal, setSelectedTestForModal] = useState<Test | null>(null);
  
  const [activeTab, setActiveTab] = useState<'nearby' | 'state' | 'nationwide'>('nearby');
  const [showFilters, setShowFilters] = useState(false);
  const [filters, setFilters] = useState({
    priceRange: 'all',
    type: 'all',
    rating: 'all',
    openNow: false,
    verified: false
  });
  const [currentPage, setCurrentPage] = useState(1);
  const [viewMode, setViewMode] = useState<'grid' | 'list'>('grid');
  const [loadedItems, setLoadedItems] = useState(4);
  const [expandedStates, setExpandedStates] = useState<Record<string, boolean>>({});
  const [isLoading, setIsLoading] = useState(false);
  const [serviceViewMode, setServiceViewMode] = useState<'grid' | 'list'>('grid');
  const itemsPerPage = 6;

  const [deliveryDetails, setDeliveryDetails] = useState({
    address: '',
    phone: '',
    preferredDate: '',
    preferredTime: '',
    notes: ''
  });

  const getFilteredCenters = () => {
    let centers = allMedicalCenters;

    switch (activeTab) {
      case 'nearby':
        centers = centers.filter(center => center.city === 'Lagos' && parseFloat(center.distance) <= 10);
        break;
      case 'state':
        centers = centers.filter(center => center.state === 'Lagos');
        break;
      case 'nationwide':
        // All centers
        break;
    }

    if (searchQuery) {
      centers = centers.filter(center => 
        center.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
        center.address.toLowerCase().includes(searchQuery.toLowerCase()) ||
        center.city.toLowerCase().includes(searchQuery.toLowerCase()) ||
        center.state.toLowerCase().includes(searchQuery.toLowerCase())
      );
    }

    if (filters.priceRange !== 'all') {
      centers = centers.filter(center => center.priceRange === filters.priceRange);
    }
    if (filters.type !== 'all') {
      centers = centers.filter(center => center.type === filters.type);
    }
    if (filters.rating !== 'all') {
      const minRating = parseFloat(filters.rating);
      centers = centers.filter(center => center.rating >= minRating);
    }
    if (filters.openNow) {
      centers = centers.filter(center => center.openingHours.isOpen);
    }
    if (filters.verified) {
      centers = centers.filter(center => center.verified);
    }

    return centers;
  };

  const getFilteredServices = () => {
    let services = testCategories;

    if (serviceSearchQuery) {
      services = services.filter(service => 
        service.name.toLowerCase().includes(serviceSearchQuery.toLowerCase()) ||
        service.description.toLowerCase().includes(serviceSearchQuery.toLowerCase())
      );
    }

    return services;
  };

  const filteredCenters = getFilteredCenters();
  const lazyLoadedCenters = filteredCenters.slice(0, loadedItems);

  const centersByState = filteredCenters.reduce((acc, center) => {
    if (!acc[center.state]) {
      acc[center.state] = [];
    }
    acc[center.state].push(center);
    return acc;
  }, {} as Record<string, MedicalCenter[]>);

  const handleSelectCenter = (center: MedicalCenter) => {
    setSelectedCenter(center);
    setStep('services');
  };

  const resetFilters = () => {
    setFilters({
      priceRange: 'all',
      type: 'all',
      rating: 'all',
      openNow: false,
      verified: false
    });
    setSearchQuery('');
    setCurrentPage(1);
    setLoadedItems(4);
  };

  const loadMoreCenters = () => {
    setIsLoading(true);
    setTimeout(() => {
      const newLoadedItems = Math.min(loadedItems + 2, filteredCenters.length);
      setLoadedItems(newLoadedItems);
      setIsLoading(false);
    }, 500);
  };

  const toggleStateExpanded = (state: string) => {
    setExpandedStates(prev => ({
      ...prev,
      [state]: !prev[state]
    }));
  };

  const handleSelectCategory = (category: TestCategory) => {
    setSelectedCategory(category);
    setStep('tests');
  };

  const handleAddToCart = (test: Test) => {
    if (!cart.find(item => item.id === test.id)) {
      setCart([...cart, test]);
    }
  };

  const handleRemoveFromCart = (testId: string) => {
    setCart(cart.filter(item => item.id !== testId));
  };

  const handleViewTestDetails = (test: Test) => {
    setSelectedTestForModal(test);
    setShowTestModal(true);
  };

  const handleCloseModal = () => {
    setShowTestModal(false);
    setSelectedTestForModal(null);
  };

  const getTotalAmount = () => {
    return cart.reduce((total, test) => total + test.price, 0);
  };

  const handleSubmitOrder = async () => {
    const orderData = {
      type: 'test',
      facility: selectedCenter?.name,
      tests: cart,
      totalAmount: getTotalAmount(),
      deliveryDetails,
      preferredDate: deliveryDetails.preferredDate,
      preferredTime: deliveryDetails.preferredTime,
      notes: deliveryDetails.notes
    };

    try {
      // Mock order creation
      console.log('Order created:', orderData);
      alert('Order placed successfully!');
    } catch (error) {
      console.error('Failed to create order:', error);
    }
  };

  const renderStepIndicator = () => (
    <div className="flex items-center justify-center mb-8">
      <div className="flex items-center space-x-4 sm:space-x-8">
        {[
          { key: 'centers', label: 'Select Center', icon: '🏥', gradient: 'from-pink-500 to-rose-500' },
          { key: 'services', label: 'Choose Service', icon: '🔬', gradient: 'from-blue-500 to-cyan-500' },
          { key: 'tests', label: 'Select Tests', icon: '📋', gradient: 'from-green-500 to-emerald-500' },
          { key: 'cart', label: 'Review Order', icon: '🛒', gradient: 'from-purple-500 to-violet-500' }
        ].map((stepItem, index) => (
          <div key={stepItem.key} className="flex items-center">
            <div className={`
              flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-2xl text-white font-bold text-lg shadow-lg transform transition-all duration-300
              ${step === stepItem.key 
                ? `bg-gradient-to-r ${stepItem.gradient} scale-110 shadow-xl animate-pulse` 
                : 'bg-gradient-to-r from-gray-400 to-gray-500 scale-100 hover:scale-105'
              }
            `}>
              <span className="text-lg sm:text-xl">{stepItem.icon}</span>
            </div>
            <div className="ml-2 sm:ml-3 hidden sm:block">
              <div className={`text-xs sm:text-sm font-semibold transition-colors ${
                step === stepItem.key ? 'text-gray-900' : 'text-gray-500'
              }`}>
                {stepItem.label}
              </div>
            </div>
            {index < 3 && (
              <div className="ml-4 sm:ml-6 w-6 sm:w-8 h-1 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full hidden sm:block"></div>
            )}
          </div>
        ))}
      </div>
    </div>
  );

  const renderCentersStep = () => (
    <div className="animate-fade-in">
      <div className="text-center mb-8">
        <h1 className="font-bold text-2xl sm:text-3xl text-gray-900 leading-tight tracking-tight mb-2">
          Select Medical Center
        </h1>
        <p className="text-gray-600 text-sm sm:text-base font-medium">
          Choose from verified medical facilities across Nigeria
        </p>
      </div>

      <div className="relative overflow-hidden bg-gradient-to-br from-white via-blue-50/50 to-purple-50/50 rounded-2xl shadow-xl border border-white/50 mb-6">
        <div className="absolute inset-0 opacity-10">
          <div className="absolute top-0 left-0 w-48 h-48 bg-white rounded-full -translate-x-24 -translate-y-24 animate-pulse"></div>
          <div className="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full translate-x-32 translate-y-32 animate-pulse delay-1000"></div>
        </div>
        
        <div className="relative">
          <div className="flex border-b border-gray-200 overflow-x-auto">
            {[
              { key: 'nearby', label: 'Nearby', shortLabel: 'Near', icon: MapPinIcon, count: allMedicalCenters.filter(c => c.city === 'Lagos' && parseFloat(c.distance) <= 10).length, gradient: 'from-emerald-500 to-teal-500' },
              { key: 'state', label: 'Lagos State', shortLabel: 'Lagos', icon: BuildingOffice2Icon, count: allMedicalCenters.filter(c => c.state === 'Lagos').length, gradient: 'from-blue-500 to-indigo-500' },
              { key: 'nationwide', label: 'Nationwide', shortLabel: 'All', icon: GlobeAltIcon, count: allMedicalCenters.length, gradient: 'from-purple-500 to-pink-500' }
            ].map((tab) => {
              const IconComponent = tab.icon;
              return (
                <button
                  key={tab.key}
                  onClick={() => {
                    setActiveTab(tab.key as any);
                    setCurrentPage(1);
                    setLoadedItems(4);
                  }}
                  className={`flex items-center justify-center gap-1.5 px-3 sm:px-6 py-3 sm:py-4 font-medium transition-all duration-300 transform hover:scale-105 text-xs sm:text-sm min-w-0 flex-1 whitespace-nowrap ${
                    activeTab === tab.key
                      ? `text-white bg-gradient-to-r ${tab.gradient} shadow-lg`
                      : 'text-gray-700 hover:text-gray-900 hover:bg-gradient-to-r hover:from-white/80 hover:to-gray-50/80'
                  }`}
                >
                  <IconComponent className="w-3.5 h-3.5 sm:w-4 sm:h-4 flex-shrink-0" />
                  <span className="hidden sm:inline font-semibold">{tab.label}</span>
                  <span className="sm:hidden font-semibold">{tab.shortLabel}</span>
                  <span className={`text-xs px-1.5 py-0.5 sm:px-2 sm:py-1 rounded-full font-bold ${
                    activeTab === tab.key 
                      ? 'bg-white/20 text-white' 
                      : 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-600'
                  }`}>
                    {tab.count}
                  </span>
                </button>
              );
            })}
          </div>

          {/* Search and Filters */}
          <div className="p-3 sm:p-6">
            <div className="flex flex-col lg:flex-row gap-3 lg:gap-4">
              {/* Premium Search */}
              <div className="flex-1 lg:max-w relative group">
                <div className="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div className="relative bg-white rounded-xl shadow-sm border border-gray-200 hover:border-blue-300 transition-all duration-300">
                  <MagnifyingGlassIcon className="absolute left-3 sm:left-4 top-1/2 transform -translate-y-1/2 h-4 w-4 sm:h-5 sm:w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" />
                  <input
                    type="text"
                    placeholder={`Search ${activeTab === 'nearby' ? 'nearby' : activeTab === 'state' ? 'Lagos state' : 'all'} medical centers...`}
                    value={searchQuery}
                    onChange={(e) => {
                      setSearchQuery(e.target.value);
                      setCurrentPage(1);
                      setLoadedItems(4);
                    }}
                    className="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 bg-transparent rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/25 text-gray-900 placeholder-gray-500 text-sm sm:text-base"
                  />
                </div>
              </div>
              
              <div className="flex gap-2 lg:gap-4">
                {/* View Mode Toggle */}
                <div className="flex items-center bg-white rounded-xl shadow-sm border border-gray-200 p-1">
                  <button
                    onClick={() => setViewMode('grid')}
                    className={`px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${
                      viewMode === 'grid' ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'
                    }`}
                  >
                    Grid
                  </button>
                  <button
                    onClick={() => setViewMode('list')}
                    className={`px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${
                      viewMode === 'list' ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'
                    }`}
                  >
                    List
                  </button>
                </div>

                {/* Filters Toggle */}
                <button
                  onClick={() => setShowFilters(!showFilters)}
                  className="flex items-center justify-center gap-2 px-4 py-2.5 sm:py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium text-sm"
                >
                  <FunnelIcon className="w-4 h-4" />
                  <span>Filters</span>
                  {Object.values(filters).some(filter => filter !== 'all' && filter !== false) && (
                    <span className="bg-white/20 text-white text-xs px-2 py-1 rounded-full font-bold">
                      Active
                    </span>
                  )}
                </button>
              </div>
            </div>

            {/* Advanced Filters */}
            {showFilters && (
              <div className="mt-4 sm:mt-6 p-3 sm:p-6 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-xl border border-gray-200 shadow-inner">
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">Facility Type</label>
                    <select
                      value={filters.type}
                      onChange={(e) => {
                        setFilters({ ...filters, type: e.target.value });
                        setCurrentPage(1);
                        setLoadedItems(4);
                      }}
                      className="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 bg-white shadow-sm"
                    >
                      <option value="all">All Types</option>
                      <option value="hospital">Hospital</option>
                      <option value="clinic">Clinic</option>
                      <option value="laboratory">Laboratory</option>
                      <option value="diagnostic_center">Diagnostic Center</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">Minimum Rating</label>
                    <select
                      value={filters.rating}
                      onChange={(e) => {
                        setFilters({ ...filters, rating: e.target.value });
                        setCurrentPage(1);
                        setLoadedItems(4);
                      }}
                      className="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 bg-white shadow-sm"
                    >
                      <option value="all">Any Rating</option>
                      <option value="4.5">4.5+ Stars</option>
                      <option value="4.0">4.0+ Stars</option>
                      <option value="3.5">3.5+ Stars</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">Price Range</label>
                    <select
                      value={filters.priceRange}
                      onChange={(e) => {
                        setFilters({ ...filters, priceRange: e.target.value });
                        setCurrentPage(1);
                        setLoadedItems(4);
                      }}
                      className="w-full border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 bg-white shadow-sm"
                    >
                      <option value="all">All Prices</option>
                      <option value="budget">Budget</option>
                      <option value="mid">Mid-range</option>
                      <option value="premium">Premium</option>
                    </select>
                  </div>

                  <div className="flex flex-col justify-center space-y-3 sm:space-y-4">
                    <label className="flex items-center">
                      <input
                        type="checkbox"
                        checked={filters.openNow}
                        onChange={(e) => {
                          setFilters({ ...filters, openNow: e.target.checked });
                          setCurrentPage(1);
                          setLoadedItems(4);
                        }}
                        className="rounded border-gray-300 text-blue-600 focus:ring-blue-500 shadow-sm"
                      />
                      <span className="ml-2 text-sm font-medium text-gray-700">Open Now</span>
                    </label>
                    <label className="flex items-center">
                      <input
                        type="checkbox"
                        checked={filters.verified}
                        onChange={(e) => {
                          setFilters({ ...filters, verified: e.target.checked });
                          setCurrentPage(1);
                          setLoadedItems(4);
                        }}
                        className="rounded border-gray-300 text-blue-600 focus:ring-blue-500 shadow-sm"
                      />
                      <span className="ml-2 text-sm font-medium text-gray-700">Verified Only</span>
                    </label>
                    <button
                      onClick={resetFilters}
                      className="px-3 py-1.5 sm:px-4 sm:py-2 text-xs sm:text-sm text-gray-600 border border-gray-300 rounded-xl hover:bg-white hover:shadow-sm transition-all duration-200 font-medium"
                    >
                      <XMarkIcon className="w-3 h-3 sm:w-4 sm:h-4 inline mr-1" />
                      Clear All
                    </button>
                  </div>
                </div>
              </div>
            )}
          </div>
        </div>
      </div>

      {/* Results Info */}
      <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mb-6 px-4 py-3 bg-white rounded-xl shadow-sm border border-gray-100">
        <div className="text-sm font-medium text-gray-600">
          Showing <span className="text-gray-900 font-bold">{Math.min(loadedItems, filteredCenters.length)}</span> of <span className="text-gray-900 font-bold">{filteredCenters.length}</span> centers
        </div>
        <div className="text-xs sm:text-sm text-gray-500">
          {activeTab === 'nearby' && 'Within 10km of your location'}
          {activeTab === 'state' && 'Lagos State facilities'}
          {activeTab === 'nationwide' && 'All centers across Nigeria'}
        </div>
      </div>

      {activeTab === 'nationwide' ? (
        <div className="space-y-8">
          {Object.entries(centersByState).map(([state, centers]) => {
            const isExpanded = expandedStates[state];
            const displayedCenters = isExpanded ? centers : centers.slice(0, 3);
            
            return (
              <div key={state}>
                <h3 className="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                  <MapIcon className="w-5 h-5 text-blue-600" />
                  {state} ({centers.length} centers)
                </h3>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  {displayedCenters.map((center) => renderCenterCard(center))}
                </div>
                {centers.length > 3 && (
                  <button 
                    onClick={() => toggleStateExpanded(state)}
                    className="mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium hover:underline transition-colors"
                  >
                    {isExpanded ? `Show less` : `View all ${centers.length} centers in ${state}`} →
                  </button>
                )}
              </div>
            );
          })}
        </div>
      ) : (
        <>
          <div className={viewMode === 'grid' 
            ? 'grid grid-cols-1 md:grid-cols-2 gap-6' 
            : 'space-y-4'
          }>
            {lazyLoadedCenters.map((center) => 
              viewMode === 'grid' ? renderCenterCard(center) : renderCenterListItem(center)
            )}
          </div>

          {/* Load More Button */}
          {loadedItems < filteredCenters.length && (
            <div className="flex flex-col items-center mt-8">
              {isLoading ? (
                <div className="flex items-center space-x-2 text-gray-600">
                  <div className="animate-spin rounded-full h-5 w-5 border-b-2 border-blue-600"></div>
                  <span>Loading more centers...</span>
                </div>
              ) : (
                <button
                  onClick={loadMoreCenters}
                  className="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 font-medium"
                >
                  Load {Math.min(2, filteredCenters.length - loadedItems)} More Centers
                </button>
              )}
            </div>
          )}
        </>
      )}

      {filteredCenters.length === 0 && (
        <div className="text-center py-12">
          <div className="text-gray-400 mb-4">
            <MapPinIcon className="w-12 h-12 mx-auto" />
          </div>
          <h3 className="text-lg font-medium text-gray-900 mb-2">No centers found</h3>
          <p className="text-gray-600 mb-4">Try adjusting your search criteria or filters</p>
          <button
            onClick={resetFilters}
            className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            Clear Filters
          </button>
        </div>
      )}
    </div>
  );

  const renderCenterCard = (center: MedicalCenter) => (
    <div
      key={center.id}
      className="group relative overflow-hidden bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:scale-[1.02] cursor-pointer"
      onClick={() => handleSelectCenter(center)}
    >
      <div className="absolute inset-0 bg-gradient-to-r from-blue-50/0 via-blue-50/0 to-indigo-50/0 group-hover:from-blue-50/30 group-hover:via-blue-50/20 group-hover:to-indigo-50/30 transition-all duration-500"></div>
      
      <div className="relative p-6">
        {/* Header with name and verification */}
        <div className="flex items-start justify-between mb-4">
          <div className="flex-1">
            <div className="flex items-center gap-2 mb-2">
              <h3 className="text-lg font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                {center.name}
              </h3>
              {center.verified && (
                <CheckCircleIcon className="w-5 h-5 text-green-500" />
              )}
            </div>
            <span className={`inline-block text-xs px-3 py-1 rounded-full font-semibold ${
              center.priceRange === 'budget' ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700' :
              center.priceRange === 'mid' ? 'bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-700' :
              'bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700'
            }`}>
              {center.priceRange.toUpperCase()}
            </span>
          </div>
          
          {/* Rating - Hidden on Mobile */}
          <div className="text-right hidden sm:block">
            <div className="flex items-center gap-1 bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-2 rounded-xl shadow-sm">
              <StarIcon className="w-4 h-4 text-yellow-400 fill-current" />
              <span className="text-sm font-bold">{center.rating}</span>
              <span className="text-xs text-gray-500">({center.reviewCount})</span>
            </div>
          </div>
        </div>

        {/* Location */}
        <div className="flex items-center text-gray-600 mb-3">
          <MapPinIcon className="w-4 h-4 mr-2 flex-shrink-0 text-blue-500" />
          <span className="text-sm flex-1">{center.address}</span>
          {activeTab === 'nearby' && (
            <span className="text-xs bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 px-2 py-1 rounded-full font-medium">
              {center.distance}
            </span>
          )}
        </div>

        {/* Operating hours */}
        <div className="flex items-center text-gray-600 mb-4">
          <ClockIcon className="w-4 h-4 mr-2 flex-shrink-0 text-teal-500" />
          <span className="text-sm flex-1">
            {center.openingHours.open} - {center.openingHours.close}
          </span>
          <span className={`px-2 py-1 rounded-full text-xs font-semibold ${
            center.openingHours.isOpen 
              ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700' 
              : 'bg-gradient-to-r from-red-100 to-pink-100 text-red-700'
          }`}>
            {center.openingHours.isOpen ? 'Open' : 'Closed'}
          </span>
        </div>

        {/* Services */}
        <div className="flex flex-wrap gap-2 mb-4">
          {center.services.slice(0, 3).map((service) => (
            <span
              key={service}
              className="px-2 py-1 bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 text-xs rounded-lg font-medium"
            >
              {service}
            </span>
          ))}
          {center.services.length > 3 && (
            <span className="px-2 py-1 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-600 text-xs rounded-lg font-medium">
              +{center.services.length - 3} more
            </span>
          )}
        </div>

        {/* Bottom section with phone and action */}
        <div className="border-t border-gray-100 pt-4 mt-4">
          <div className="flex items-center justify-between">
            <div className="flex items-center text-gray-700">
              <PhoneIcon className="w-4 h-4 mr-2 text-green-600" />
              <span className="text-sm font-medium">{center.phone}</span>
            </div>
            <ChevronRightIcon className="w-5 h-5 text-blue-600 group-hover:translate-x-1 transition-transform" />
          </div>
        </div>
      </div>
    </div>
  );

  const renderCenterListItem = (center: MedicalCenter) => (
    <div
      key={center.id}
      className="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-lg hover:border-blue-200 transition-all duration-300 cursor-pointer"
      onClick={() => handleSelectCenter(center)}
    >
      <div className="space-y-3">
        {/* Header with name and badges */}
        <div className="flex items-start justify-between">
          <div className="flex-1 min-w-0">
            <div className="flex items-center gap-2 mb-2">
              <h3 className="text-lg font-bold text-gray-900 truncate">{center.name}</h3>
              {center.verified && <CheckCircleIcon className="w-4 h-4 text-green-500 flex-shrink-0" />}
            </div>
            <div className="flex flex-wrap gap-2">
              <span className={`text-xs px-2 py-1 rounded-full font-semibold ${
                center.priceRange === 'budget' ? 'bg-green-100 text-green-700' :
                center.priceRange === 'mid' ? 'bg-yellow-100 text-yellow-700' :
                'bg-blue-100 text-blue-700'
              }`}>
                {center.priceRange}
              </span>
              <span className={`text-xs px-2 py-1 rounded-full font-medium ${
                center.type === 'hospital' ? 'bg-red-100 text-red-700' :
                center.type === 'clinic' ? 'bg-blue-100 text-blue-700' :
                center.type === 'laboratory' ? 'bg-green-100 text-green-700' :
                'bg-purple-100 text-purple-700'
              }`}>
                {center.type.replace('_', ' ')}
              </span>
              <span className={`text-xs px-2 py-1 rounded-full font-medium ${
                center.openingHours.isOpen 
                  ? 'bg-green-100 text-green-700' 
                  : 'bg-red-100 text-red-700'
              }`}>
                {center.openingHours.isOpen ? 'Open' : 'Closed'}
              </span>
            </div>
          </div>
          <div className="flex-shrink-0 ml-3">
            <ChevronRightIcon className="w-5 h-5 text-blue-600" />
          </div>
        </div>
        
        {/* Location and hours */}
        <div className="space-y-2 text-sm text-gray-600">
          <div className="flex items-center">
            <MapPinIcon className="w-4 h-4 mr-2 flex-shrink-0 text-blue-500" />
            <span className="flex-1 truncate">{center.address}</span>
            {activeTab === 'nearby' && (
              <span className="ml-2 text-blue-600 font-medium flex-shrink-0">{center.distance}</span>
            )}
          </div>
          <div className="flex items-center justify-between">
            <div className="flex items-center">
              <ClockIcon className="w-4 h-4 mr-2 flex-shrink-0 text-teal-500" />
              <span>{center.openingHours.open} - {center.openingHours.close}</span>
            </div>
            <div className="flex items-center hidden sm:flex">
              <StarIcon className="w-4 h-4 mr-1 text-yellow-400 fill-current" />
              <span className="font-medium">{center.rating}</span>
              <span className="text-gray-500 ml-1">({center.reviewCount})</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  );

  const renderServicesStep = () => (
    <div className="animate-fade-in">
      <div className="flex items-center gap-4 mb-8">
        <button
          onClick={() => setStep('centers')}
          className="p-3 hover:bg-gray-100 rounded-xl transition-colors shadow-sm border border-gray-200"
        >
          <ArrowLeftIcon className="w-5 h-5" />
        </button>
        <div>
          <h1 className="text-2xl sm:text-3xl font-bold text-gray-900">{selectedCenter?.name}</h1>
          <p className="text-gray-600 font-medium">Select a service category</p>
        </div>
      </div>

      <div className="relative overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-6">
        <div className="absolute inset-0 bg-gradient-to-br from-blue-50/30 to-indigo-50/30 opacity-50"></div>
        
        <div className="relative">
          <div className="flex items-center justify-between mb-6">
            <div>
              <h3 className="text-lg font-bold text-gray-900 mb-1">Available Services</h3>
              <p className="text-sm text-gray-600">Choose the type of medical service you need</p>
            </div>
            <div className="text-right hidden sm:block">
              <h4 className="text-sm font-semibold text-gray-700 mb-1">Center Rating</h4>
              <div className="flex items-center gap-2 bg-gradient-to-r from-yellow-50 to-amber-50 px-3 py-2 rounded-xl">
                <StarIcon className="w-5 h-5 text-yellow-400 fill-current" />
                <span className="font-bold">{selectedCenter?.rating}</span>
                <span className="text-gray-500 text-sm">({selectedCenter?.reviewCount} reviews)</span>
              </div>
            </div>
          </div>

          {/* Search and View Controls */}
          <div className="flex flex-col sm:flex-row gap-4">
            {/* Premium Search */}
            <div className="flex-1 relative group">
              <div className="absolute inset-0 bg-gradient-to-r from-blue-600/10 to-indigo-600/10 rounded-xl blur opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
              <div className="relative bg-white rounded-xl shadow-sm border border-gray-200 hover:border-blue-300 transition-all duration-300">
                <MagnifyingGlassIcon className="absolute left-4 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400 group-hover:text-blue-500 transition-colors duration-300" />
                <input
                  type="text"
                  placeholder="Search services..."
                  value={serviceSearchQuery}
                  onChange={(e) => setServiceSearchQuery(e.target.value)}
                  className="w-full pl-12 pr-4 py-3 bg-transparent rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-500/25 text-gray-900 placeholder-gray-500"
                />
              </div>
            </div>
            
            {/* View Mode Toggle */}
            <div className="flex items-center bg-white rounded-xl shadow-sm border border-gray-200 p-1">
              <button
                onClick={() => setServiceViewMode('grid')}
                className={`px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${
                  serviceViewMode === 'grid' ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'
                }`}
              >
                Grid
              </button>
              <button
                onClick={() => setServiceViewMode('list')}
                className={`px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 ${
                  serviceViewMode === 'list' ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-sm' : 'text-gray-600 hover:text-gray-900'
                }`}
              >
                List
              </button>
            </div>
          </div>

          {/* Results Info */}
          <div className="mt-4 text-sm font-medium text-gray-600">
            Showing <span className="text-gray-900 font-bold">{getFilteredServices().length}</span> of <span className="text-gray-900 font-bold">{testCategories.length}</span> services
          </div>
        </div>
      </div>

      {serviceViewMode === 'grid' ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
          {getFilteredServices().map((category) => {
            const IconComponent = category.icon === 'BeakerIcon' ? BeakerIcon 
                                : category.icon === 'ShieldExclamationIcon' ? ShieldExclamationIcon
                                : category.icon === 'HeartIcon' ? HeartIcon
                                : ScaleIcon;
            
            return (
              <div
                key={category.id}
                className="group relative overflow-hidden bg-white rounded-xl lg:rounded-2xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-lg hover:border-blue-200 transition-all duration-300 cursor-pointer"
                onClick={() => handleSelectCategory(category)}
              >
                <div className="absolute inset-0 bg-gradient-to-br from-blue-50/0 to-indigo-50/0 group-hover:from-blue-50/50 group-hover:to-indigo-50/30 transition-all duration-500"></div>
                
                {/* Mobile Layout */}
                <div className="relative lg:hidden">
                  <div className="flex items-start space-x-3">
                    <div className="flex-shrink-0">
                      <div className="p-3 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl group-hover:from-blue-100 group-hover:to-indigo-100 transition-all duration-300">
                        <IconComponent className="w-6 h-6 text-blue-600 group-hover:text-blue-700" />
                      </div>
                    </div>
                    <div className="flex-1 min-w-0">
                      <h3 className="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors leading-tight">{category.name}</h3>
                      <p className="text-gray-600 text-sm mb-3 line-clamp-2">{category.description}</p>
                      <div className="flex items-center text-xs text-gray-500 space-x-3">
                        <span className="font-medium">{category.testCount} tests</span>
                        <span>•</span>
                        <span className="font-medium">{category.priceRange}</span>
                      </div>
                    </div>
                    <div className="flex-shrink-0">
                      <ChevronRightIcon className="w-5 h-5 text-blue-600 group-hover:translate-x-1 transition-all duration-300" />
                    </div>
                  </div>
                </div>

                {/* Desktop Layout */}
                <div className="relative hidden lg:block text-center">
                  <div className="flex justify-center mb-4">
                    <div className="p-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl group-hover:from-blue-100 group-hover:to-indigo-100 group-hover:scale-110 transition-all duration-300 shadow-lg">
                      <IconComponent className="w-8 h-8 text-blue-600 group-hover:text-blue-700" />
                    </div>
                  </div>
                  <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">{category.name}</h3>
                  <p className="text-gray-600 text-sm mb-6">{category.description}</p>
                  <div className="space-y-3 mb-6">
                    <div className="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-xl">
                      <span className="text-sm font-medium text-gray-700">Tests Available:</span>
                      <span className="text-blue-600 font-bold">{category.testCount} tests</span>
                    </div>
                    <div className="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-green-50/50 rounded-xl">
                      <span className="text-sm font-medium text-gray-700">Price Range:</span>
                      <span className="text-gray-700 font-bold text-sm">{category.priceRange}</span>
                    </div>
                  </div>
                  <div className="flex items-center justify-center pt-4 border-t border-gray-100 group-hover:border-blue-200">
                    <span className="text-sm text-blue-600 font-semibold mr-2 group-hover:text-blue-700">View Tests</span>
                    <ChevronRightIcon className="w-4 h-4 text-blue-600 group-hover:translate-x-1 group-hover:text-blue-700 transition-all duration-300" />
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      ) : (
        <div className="space-y-3">
          {getFilteredServices().map((category) => {
            const IconComponent = category.icon === 'BeakerIcon' ? BeakerIcon 
                                : category.icon === 'ShieldExclamationIcon' ? ShieldExclamationIcon
                                : category.icon === 'HeartIcon' ? HeartIcon
                                : ScaleIcon;
            
            return (
              <div
                key={category.id}
                className="bg-white rounded-xl shadow-sm border border-gray-100 p-4 hover:shadow-lg hover:border-blue-200 transition-all duration-300 cursor-pointer"
                onClick={() => handleSelectCategory(category)}
              >
                <div className="flex items-center space-x-4">
                  <div className="flex-shrink-0">
                    <div className="p-3 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm">
                      <IconComponent className="w-6 h-6 text-blue-600" />
                    </div>
                  </div>
                  <div className="flex-1 min-w-0">
                    <h3 className="text-lg font-bold text-gray-900 mb-1">{category.name}</h3>
                    <p className="text-gray-600 text-sm mb-2 line-clamp-2">{category.description}</p>
                    <div className="flex items-center space-x-4 text-sm text-gray-500">
                      <span className="font-medium">{category.testCount} tests</span>
                      <span>•</span>
                      <span className="font-medium">{category.priceRange}</span>
                    </div>
                  </div>
                  <div className="flex-shrink-0">
                    <ChevronRightIcon className="w-5 h-5 text-blue-600" />
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      )}

      {/* No results message */}
      {getFilteredServices().length === 0 && (
        <div className="text-center py-12">
          <div className="text-gray-400 mb-4">
            <BeakerIcon className="w-12 h-12 mx-auto" />
          </div>
          <h3 className="text-lg font-medium text-gray-900 mb-2">No services found</h3>
          <p className="text-gray-600 mb-4">Try adjusting your search terms</p>
          <button
            onClick={() => setServiceSearchQuery('')}
            className="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
          >
            Clear Search
          </button>
        </div>
      )}
    </div>
  );

  const renderTestsStep = () => (
    <div className="animate-fade-in">
      <div className="flex items-center gap-4 mb-8">
        <button
          onClick={() => setStep('services')}
          className="p-3 hover:bg-gray-100 rounded-xl transition-colors shadow-sm border border-gray-200"
        >
          <ArrowLeftIcon className="w-5 h-5" />
        </button>
        <div>
          <h1 className="text-2xl sm:text-3xl font-bold text-gray-900">{selectedCategory?.name}</h1>
          <p className="text-gray-600 font-medium">{selectedCategory?.description}</p>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2">
          <div className="space-y-4 lg:space-y-6">
            {selectedCategory?.tests.map((test) => (
              <div
                key={test.id}
                className="group relative overflow-hidden bg-white rounded-xl lg:rounded-2xl shadow-sm hover:shadow-lg border border-gray-100 hover:border-blue-200 transition-all duration-300 p-4 lg:p-6"
              >
                <div className="absolute inset-0 bg-gradient-to-br from-blue-50/0 to-indigo-50/0 group-hover:from-blue-50/30 group-hover:to-indigo-50/20 transition-all duration-500"></div>
                
                <div className="relative">
                  {/* Mobile Layout */}
                  <div className="lg:hidden">
                    <div className="flex items-start justify-between mb-3">
                      <div className="flex-1 min-w-0 pr-3">
                        <h3 className="text-lg font-bold text-gray-900 mb-1 group-hover:text-blue-700 transition-colors leading-tight">{test.name}</h3>
                        <p className="text-gray-600 text-sm mb-3 line-clamp-2">{test.description}</p>
                      </div>
                      <div className="text-right flex-shrink-0">
                        <div className="text-xl font-bold text-blue-600 mb-2">
                          ₦{test.price.toLocaleString()}
                        </div>
                      </div>
                    </div>
                    
                    {/* Mobile Info Cards - Horizontal */}
                    <div className="flex gap-2 mb-4 overflow-x-auto pb-1">
                      <div className="flex-shrink-0 p-2 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-lg min-w-0">
                        <div className="text-xs font-semibold text-gray-700 mb-1">Results</div>
                        <div className="text-xs text-gray-600">{test.resultTime}</div>
                      </div>
                      <div className="flex-shrink-0 p-2 bg-gradient-to-r from-gray-50 to-green-50/50 rounded-lg min-w-0">
                        <div className="text-xs font-semibold text-gray-700 mb-1">Fasting</div>
                        <div className="text-xs text-gray-600">{test.fasting ? 'Required' : 'Not required'}</div>
                      </div>
                      <div className="flex-shrink-0 p-2 bg-gradient-to-r from-gray-50 to-purple-50/50 rounded-lg min-w-0">
                        <div className="text-xs font-semibold text-gray-700 mb-1">Prep</div>
                        <div className="text-xs text-gray-600">{test.preparationTime}</div>
                      </div>
                    </div>
                    
                    {/* Mobile Action Buttons */}
                    <div className="flex gap-2">
                      <button
                        onClick={() => handleViewTestDetails(test)}
                        className="flex-1 px-3 py-2 rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-50 transition-all duration-200 text-sm font-semibold"
                      >
                        Details
                      </button>
                      <button
                        onClick={() => handleAddToCart(test)}
                        disabled={cart.some(item => item.id === test.id)}
                        className={`flex-1 px-3 py-2 rounded-lg font-semibold transition-all duration-200 text-sm ${
                          cart.some(item => item.id === test.id)
                            ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 cursor-not-allowed'
                            : 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700'
                        }`}
                      >
                        {cart.some(item => item.id === test.id) ? 'Added ✓' : 'Add to Cart'}
                      </button>
                    </div>
                  </div>

                  {/* Desktop Layout */}
                  <div className="hidden lg:block">
                    <div className="flex items-start justify-between mb-4">
                      <div className="flex-1">
                        <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">{test.name}</h3>
                        <p className="text-gray-600 text-sm mb-4">{test.description}</p>
                        
                        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                          <div className="p-3 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-xl">
                            <span className="font-semibold text-gray-700 block mb-1">Preparation:</span>
                            <p className="text-gray-600">{test.preparationTime}</p>
                          </div>
                          <div className="p-3 bg-gradient-to-r from-gray-50 to-green-50/50 rounded-xl">
                            <span className="font-semibold text-gray-700 block mb-1">Results:</span>
                            <p className="text-gray-600">{test.resultTime}</p>
                          </div>
                          <div className="p-3 bg-gradient-to-r from-gray-50 to-purple-50/50 rounded-xl">
                            <span className="font-semibold text-gray-700 block mb-1">Fasting:</span>
                            <p className="text-gray-600">{test.fasting ? 'Required' : 'Not required'}</p>
                          </div>
                        </div>
                      </div>
                      <div className="text-right ml-6">
                        <div className="text-2xl font-bold text-blue-600 mb-4">
                          ₦{test.price.toLocaleString()}
                        </div>
                        <div className="space-y-3">
                          <button
                            onClick={() => handleViewTestDetails(test)}
                            className="w-full px-4 py-2.5 rounded-xl border border-blue-600 text-blue-600 hover:bg-blue-50 transition-all duration-200 text-sm font-semibold shadow-sm hover:shadow-md"
                          >
                            View Details
                          </button>
                          <button
                            onClick={() => handleAddToCart(test)}
                            disabled={cart.some(item => item.id === test.id)}
                            className={`w-full px-4 py-2.5 rounded-xl font-semibold transition-all duration-200 shadow-sm hover:shadow-md ${
                              cart.some(item => item.id === test.id)
                                ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 cursor-not-allowed'
                                : 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105'
                            }`}
                          >
                            {cart.some(item => item.id === test.id) ? 'Added ✓' : 'Add to Cart'}
                          </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div className="lg:col-span-1">
          <div className="relative overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sticky top-6">
            <div className="absolute inset-0 bg-gradient-to-br from-blue-50/30 to-indigo-50/30 opacity-50"></div>
            
            <div className="relative">
              <div className="flex items-center gap-2 mb-6">
                <ShoppingCartIcon className="w-5 h-5 text-blue-600" />
                <h3 className="text-lg font-bold text-gray-900">Cart ({cart.length})</h3>
              </div>
              
              {cart.length === 0 ? (
                <div className="text-center py-8">
                  <ShoppingCartIcon className="w-12 h-12 text-gray-300 mx-auto mb-3" />
                  <p className="text-gray-500">No tests selected</p>
                </div>
              ) : (
                <>
                  <div className="space-y-3 mb-6">
                    {cart.map((test) => (
                      <div key={test.id} className="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-xl">
                        <div className="flex-1">
                          <h4 className="font-semibold text-gray-900 text-sm">{test.name}</h4>
                          <p className="text-blue-600 font-bold">₦{test.price.toLocaleString()}</p>
                        </div>
                        <button
                          onClick={() => handleRemoveFromCart(test.id)}
                          className="text-red-500 hover:text-red-700 p-1 hover:bg-red-50 rounded-lg transition-colors"
                        >
                          <XMarkIcon className="w-4 h-4" />
                        </button>
                      </div>
                    ))}
                  </div>
                  
                  <div className="border-t border-gray-200 pt-4 mb-6">
                    <div className="flex items-center justify-between text-lg font-bold">
                      <span>Total:</span>
                      <span className="text-blue-600">₦{getTotalAmount().toLocaleString()}</span>
                    </div>
                  </div>
                  
                  <button
                    onClick={() => setStep('cart')}
                    className="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:scale-105"
                  >
                    Proceed to Checkout
                  </button>
                </>
              )}
            </div>
          </div>
        </div>
      </div>
    </div>
  );

  const renderCartStep = () => (
    <div className="animate-fade-in">
      <div className="flex items-center gap-4 mb-8">
        <button
          onClick={() => setStep('tests')}
          className="p-3 hover:bg-gray-100 rounded-xl transition-colors shadow-sm border border-gray-200"
        >
          <ArrowLeftIcon className="w-5 h-5" />
        </button>
        <div>
          <h1 className="text-2xl sm:text-3xl font-bold text-gray-900">Review Your Order</h1>
          <p className="text-gray-600 font-medium">Confirm your tests and provide delivery details</p>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div className="lg:col-span-1">
          <div className="relative overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100 p-6">
            <div className="absolute inset-0 bg-gradient-to-br from-blue-50/30 to-indigo-50/30 opacity-50"></div>
            
            <div className="relative">
              <h3 className="text-lg font-bold text-gray-900 mb-6">Delivery Information</h3>
              
              <form className="space-y-6">
                <div>
                  <label className="block text-sm font-semibold text-gray-700 mb-2">
                    Delivery Address *
                  </label>
                  <textarea
                    value={deliveryDetails.address}
                    onChange={(e) => setDeliveryDetails({ ...deliveryDetails, address: e.target.value })}
                    rows={3}
                    className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 shadow-sm"
                    placeholder="Enter your full address..."
                    required
                  />
                </div>
                
                <div>
                  <label className="block text-sm font-semibold text-gray-700 mb-2">
                    Phone Number *
                  </label>
                  <input
                    type="tel"
                    value={deliveryDetails.phone}
                    onChange={(e) => setDeliveryDetails({ ...deliveryDetails, phone: e.target.value })}
                    className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 shadow-sm"
                    placeholder="+234 800 000 0000"
                    required
                  />
                </div>
                
                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      Preferred Date *
                    </label>
                    <input
                      type="date"
                      value={deliveryDetails.preferredDate}
                      onChange={(e) => setDeliveryDetails({ ...deliveryDetails, preferredDate: e.target.value })}
                      className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 shadow-sm"
                      required
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-semibold text-gray-700 mb-2">
                      Preferred Time *
                    </label>
                    <select
                      value={deliveryDetails.preferredTime}
                      onChange={(e) => setDeliveryDetails({ ...deliveryDetails, preferredTime: e.target.value })}
                      className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 shadow-sm"
                      required
                    >
                      <option value="">Select time</option>
                      <option value="morning">Morning (8AM - 12PM)</option>
                      <option value="afternoon">Afternoon (12PM - 4PM)</option>
                      <option value="evening">Evening (4PM - 7PM)</option>
                    </select>
                  </div>
                </div>
                
                <div>
                  <label className="block text-sm font-semibold text-gray-700 mb-2">
                    Additional Notes
                  </label>
                  <textarea
                    value={deliveryDetails.notes}
                    onChange={(e) => setDeliveryDetails({ ...deliveryDetails, notes: e.target.value })}
                    rows={3}
                    className="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-4 focus:ring-blue-500/25 focus:border-blue-500 shadow-sm"
                    placeholder="Any special instructions..."
                  />
                </div>
              </form>
            </div>
          </div>
        </div>

        <div className="lg:col-span-1">
          <div className="relative overflow-hidden bg-white rounded-2xl shadow-xl border border-gray-100 p-6 sticky top-6">
            <div className="absolute inset-0 bg-gradient-to-br from-blue-50/30 to-indigo-50/30 opacity-50"></div>
            
            <div className="relative">
              <h3 className="text-lg font-bold text-gray-900 mb-6">Order Summary</h3>
              
              <div className="space-y-4 mb-6">
                <div className="flex justify-between p-3 bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-xl">
                  <span className="font-medium">Tests ({cart.length})</span>
                  <span className="text-blue-600 font-bold">₦{getTotalAmount().toLocaleString()}</span>
                </div>
                <div className="flex justify-between p-3 bg-gradient-to-r from-gray-50 to-green-50/50 rounded-xl">
                  <span className="font-medium">Home Collection</span>
                  <span className="font-bold">₦2,000</span>
                </div>
                <div className="border-t border-gray-200 pt-4">
                  <div className="flex justify-between font-bold text-xl">
                    <span>Total</span>
                    <span className="text-blue-600">₦{(getTotalAmount() + 2000).toLocaleString()}</span>
                  </div>
                </div>
              </div>
              
              <button
                onClick={handleSubmitOrder}
                disabled={!deliveryDetails.address || !deliveryDetails.phone || !deliveryDetails.preferredDate || !deliveryDetails.preferredTime}
                className="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-4 rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 font-bold disabled:from-gray-300 disabled:to-gray-400 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transform hover:scale-105 disabled:transform-none"
              >
                Place Order
              </button>
              
              <div className="mt-4 text-center">
                <p className="text-xs text-gray-500">
                  By placing this order, you agree to our terms and conditions
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );

  const renderTestModal = () => {
    if (!showTestModal || !selectedTestForModal) return null;

    return (
      <div className="fixed inset-0 bg-black/20 backdrop-blur-md flex items-center justify-center z-50 p-4">
        <div className="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
          <div className="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6 rounded-t-2xl">
            <div className="flex items-center justify-between">
              <div>
                <h2 className="text-2xl font-bold">{selectedTestForModal.name}</h2>
                {selectedTestForModal.alternateName && (
                  <p className="text-blue-100 mt-1">Also known as: {selectedTestForModal.alternateName}</p>
                )}
              </div>
              <button
                onClick={handleCloseModal}
                className="text-white hover:text-gray-200 text-2xl font-bold p-2 hover:bg-white/10 rounded-xl transition-colors"
              >
                <XMarkIcon className="w-6 h-6" />
              </button>
            </div>
          </div>

          <div className="p-6">
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <div className="lg:col-span-2 space-y-6">
                <div className="bg-gradient-to-r from-gray-50 to-blue-50/50 rounded-xl p-4">
                  <h3 className="font-bold text-gray-900 mb-2">Test Overview</h3>
                  <p className="text-gray-700">{selectedTestForModal.detailedDescription}</p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <h4 className="font-semibold text-gray-900 mb-2">Fasting Required</h4>
                    <p className="text-gray-700">{selectedTestForModal.fasting ? 'Yes' : 'No'}</p>
                  </div>
                  
                  <div className="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <h4 className="font-semibold text-gray-900 mb-2">Lab</h4>
                    <p className="text-gray-700">{selectedTestForModal.lab}</p>
                  </div>
                  
                  <div className="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <h4 className="font-semibold text-gray-900 mb-2">Specimen</h4>
                    <p className="text-gray-700">{selectedTestForModal.specimen}</p>
                  </div>
                  
                  <div className="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <h4 className="font-semibold text-gray-900 mb-2">Results</h4>
                    <p className="text-gray-700">{selectedTestForModal.averageProcessingTime}</p>
                  </div>
                </div>

                <div className="bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200 rounded-xl p-4">
                  <h4 className="font-semibold text-yellow-800 mb-2">Special Instructions</h4>
                  <p className="text-yellow-700 text-sm">{selectedTestForModal.specialInstructions}</p>
                </div>

                <div className="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-4">
                  <h4 className="font-semibold text-blue-800 mb-2">Collection Instructions</h4>
                  <p className="text-blue-700 text-sm">{selectedTestForModal.collectionInstructions}</p>
                </div>

                <div className="bg-gradient-to-r from-gray-50 to-slate-50 border border-gray-200 rounded-xl p-4">
                  <h4 className="font-semibold text-gray-900 mb-2">Additional Information</h4>
                  <p className="text-gray-700 text-sm">{selectedTestForModal.additionalInformation}</p>
                </div>
              </div>

              <div className="lg:col-span-1">
                <div className="bg-white border border-gray-200 rounded-xl p-6 sticky top-6 shadow-lg">
                  <div className="text-center mb-6">
                    <div className="text-3xl font-bold text-blue-600 mb-2">
                      ₦{selectedTestForModal.price.toLocaleString()}
                    </div>
                    <p className="text-gray-600 text-sm">Test Fee</p>
                  </div>

                  <div className="space-y-4 mb-6">
                    <div className="flex justify-between text-sm p-3 bg-gray-50 rounded-xl">
                      <span className="text-gray-600 font-medium">Processing Time:</span>
                      <span className="font-semibold">{selectedTestForModal.resultTime}</span>
                    </div>
                    <div className="flex justify-between text-sm p-3 bg-gray-50 rounded-xl">
                      <span className="text-gray-600 font-medium">Preparation:</span>
                      <span className="font-semibold text-right">{selectedTestForModal.preparationTime}</span>
                    </div>
                  </div>

                  <div className="space-y-3">
                    <button
                      onClick={() => {
                        handleAddToCart(selectedTestForModal);
                        handleCloseModal();
                      }}
                      disabled={cart.some(item => item.id === selectedTestForModal.id)}
                      className={`w-full py-3 px-4 rounded-xl font-semibold transition-all duration-300 ${
                        cart.some(item => item.id === selectedTestForModal.id)
                          ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 cursor-not-allowed'
                          : 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white hover:from-blue-700 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:scale-105'
                      }`}
                    >
                      {cart.some(item => item.id === selectedTestForModal.id) ? 'Added to Cart ✓' : 'Add to Cart'}
                    </button>
                    
                    <button
                      onClick={handleCloseModal}
                      className="w-full py-3 px-4 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors font-medium"
                    >
                      Close
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  };

  return (
    <>
      <div className="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50/30 to-indigo-50/50">
        <div className="max-w-7xl mx-auto p-4 sm:p-6">
          <div className="relative overflow-hidden bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-6 sm:p-8">
            {/* Subtle decorative background elements */}
            <div className="absolute top-0 right-0 w-48 h-48 bg-gradient-to-br from-blue-100/20 to-green-100/20 rounded-full blur-3xl -translate-y-24 translate-x-24"></div>
            <div className="absolute bottom-0 left-0 w-36 h-36 bg-gradient-to-tr from-teal-100/20 to-blue-100/20 rounded-full blur-3xl translate-y-18 -translate-x-18"></div>
            
            <div className="relative z-10">
              {renderStepIndicator()}
              
              {step === 'centers' && renderCentersStep()}
              {step === 'services' && renderServicesStep()}
              {step === 'tests' && renderTestsStep()}
              {step === 'cart' && renderCartStep()}
            </div>
          </div>
        </div>
      </div>
      
      {/* Modal rendered outside main container */}
      {renderTestModal()}
    </>
  );
}