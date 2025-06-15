'use client';

import React, { useState } from 'react';
import { useRouter } from 'next/navigation';
import { useStore } from '@/store/useStore';
import { 
  MapPinIcon, 
  ClockIcon, 
  StarIcon,
  PhoneIcon,
  ChevronRightIcon,
  MagnifyingGlassIcon,
  AdjustmentsHorizontalIcon,
  CheckCircleIcon,
  ShoppingCartIcon,
  ArrowLeftIcon,
  BeakerIcon,
  ShieldExclamationIcon,
  HeartIcon,
  ScaleIcon,
  MapIcon,
  FunnelIcon,
  XMarkIcon,
  BuildingOffice2Icon,
  GlobeAltIcon
} from '@heroicons/react/24/outline';

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
  {
    id: '5',
    name: 'Ikeja General Hospital Lab',
    address: '1 Hospital Road, Ikeja, Lagos',
    distance: '12.5 km',
    city: 'Ikeja',
    state: 'Lagos',
    rating: 4.3,
    reviewCount: 198,
    phone: '+234 1 234 5678',
    openingHours: { open: '6:00 AM', close: '8:00 PM', isOpen: true },
    services: ['General Lab Tests', 'Emergency Services', 'Pathology'],
    verified: true,
    image: '/images/ikeja-general.jpg',
    priceRange: 'budget',
    type: 'hospital'
  },
  {
    id: '6',
    name: 'Surulere Medical Centre',
    address: '25 Bode Thomas Street, Surulere, Lagos',
    distance: '8.2 km',
    city: 'Surulere',
    state: 'Lagos',
    rating: 4.1,
    reviewCount: 142,
    phone: '+234 1 345 6789',
    openingHours: { open: '7:00 AM', close: '7:00 PM', isOpen: true },
    services: ['Lab Tests', 'Imaging', 'Consultation'],
    verified: true,
    image: '/images/surulere-medical.jpg',
    priceRange: 'mid',
    type: 'clinic'
  },
  {
    id: '7',
    name: 'University College Hospital',
    address: 'Queen Elizabeth Road, Ibadan, Oyo',
    distance: '128 km',
    city: 'Ibadan',
    state: 'Oyo',
    rating: 4.7,
    reviewCount: 445,
    phone: '+234 2 241 3204',
    openingHours: { open: '24 Hours', close: '24 Hours', isOpen: true },
    services: ['Comprehensive Lab Services', 'Research', 'Specialist Care'],
    verified: true,
    image: '/images/uch-ibadan.jpg',
    priceRange: 'mid',
    type: 'hospital'
  },
  {
    id: '8',
    name: 'National Hospital Abuja',
    address: 'Central Business District, Abuja, FCT',
    distance: '472 km',
    city: 'Abuja',
    state: 'FCT',
    rating: 4.5,
    reviewCount: 332,
    phone: '+234 9 461 0012',
    openingHours: { open: '24 Hours', close: '24 Hours', isOpen: true },
    services: ['Advanced Diagnostics', 'Specialist Lab', 'Research'],
    verified: true,
    image: '/images/national-hospital.jpg',
    priceRange: 'premium',
    type: 'hospital'
  },
  {
    id: '9',
    name: 'Kano State Specialist Hospital',
    address: 'Nasarawa GRA, Kano, Kano',
    distance: '748 km',
    city: 'Kano',
    state: 'Kano',
    rating: 4.2,
    reviewCount: 201,
    phone: '+234 64 633 910',
    openingHours: { open: '6:00 AM', close: '10:00 PM', isOpen: true },
    services: ['General Lab', 'Pathology', 'Blood Bank'],
    verified: true,
    image: '/images/kano-specialist.jpg',
    priceRange: 'budget',
    type: 'hospital'
  },
  {
    id: '10',
    name: 'Port Harcourt Teaching Hospital',
    address: 'Harley Street, Port Harcourt, Rivers',
    distance: '435 km',
    city: 'Port Harcourt',
    state: 'Rivers',
    rating: 4.6,
    reviewCount: 287,
    phone: '+234 84 462 077',
    openingHours: { open: '24 Hours', close: '24 Hours', isOpen: true },
    services: ['Teaching Hospital Labs', 'Research', 'Specialized Tests'],
    verified: true,
    image: '/images/porth-teaching.jpg',
    priceRange: 'mid',
    type: 'hospital'
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

export default function NewOrder() {
  const router = useRouter();
  const store = useStore();
  
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
  const totalPages = Math.ceil(filteredCenters.length / itemsPerPage);
  const paginatedCenters = filteredCenters.slice(
    (currentPage - 1) * itemsPerPage,
    currentPage * itemsPerPage
  );

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
      await store.createOrder(orderData);
      router.push('/orders?success=true');
    } catch (error) {
      console.error('Failed to create order:', error);
    }
  };

  const renderStepIndicator = () => (
    <div className="flex items-center justify-center mb-8">
      <div className="flex items-center space-x-8">
        {[
          { key: 'centers', label: 'Select Center', icon: '🏥', color: 'from-pink-500 to-rose-500' },
          { key: 'services', label: 'Choose Service', icon: '🔬', color: 'from-blue-500 to-cyan-500' },
          { key: 'tests', label: 'Select Tests', icon: '📋', color: 'from-green-500 to-emerald-500' },
          { key: 'cart', label: 'Review Order', icon: '🛒', color: 'from-purple-500 to-violet-500' }
        ].map((stepItem, index) => (
          <div key={stepItem.key} className="flex items-center">
            <div className={`
              flex items-center justify-center w-12 h-12 rounded-2xl text-white font-bold text-lg shadow-lg transform transition-all duration-300
              ${step === stepItem.key 
                ? `bg-gradient-to-r ${stepItem.color} scale-110 shadow-xl animate-pulse` 
                : 'bg-gradient-to-r from-gray-400 to-gray-500 scale-100 hover:scale-105'
              }
            `}>
              <span className="text-xl">{stepItem.icon}</span>
            </div>
            <div className="ml-3 hidden sm:block">
              <div className={`text-sm font-semibold transition-colors ${
                step === stepItem.key ? 'text-gray-900' : 'text-gray-500'
              }`}>
              {stepItem.label}
              </div>
            </div>
            {index < 3 && (
              <div className="ml-6 w-8 h-1 bg-gradient-to-r from-gray-300 to-gray-400 rounded-full hidden sm:block"></div>
            )}
          </div>
        ))}
      </div>
    </div>
  );

  const renderCentersStep = () => (
    <div className="animate-fade-in">
      <div className="text-center mb-8">
        <h1 className="text-3xl font-bold text-gray-800 mb-2">Select Medical Center</h1>
        <p className="text-gray-600">Choose from verified medical facilities across Nigeria</p>
      </div>

      <div className="bg-gradient-to-r from-white via-blue-50/50 to-purple-50/50 rounded-2xl shadow-xl border border-white/50 mb-6 overflow-hidden">
        <div className="flex border-b border-gradient-to-r from-pink-200/50 to-blue-200/50">
          {[
            { key: 'nearby', label: 'Nearby', icon: MapPinIcon, count: allMedicalCenters.filter(c => c.city === 'Lagos' && parseFloat(c.distance) <= 10).length, gradient: 'from-emerald-500 to-teal-500' },
            { key: 'state', label: 'Lagos State', icon: BuildingOffice2Icon, count: allMedicalCenters.filter(c => c.state === 'Lagos').length, gradient: 'from-blue-500 to-indigo-500' },
            { key: 'nationwide', label: 'Nationwide', icon: GlobeAltIcon, count: allMedicalCenters.length, gradient: 'from-purple-500 to-pink-500' }
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
                className={`flex-1 flex items-center justify-center gap-2 px-6 py-4 font-medium transition-all duration-300 transform hover:scale-105 ${
                  activeTab === tab.key
                    ? `text-white bg-gradient-to-r ${tab.gradient} shadow-lg`
                    : 'text-gray-700 hover:text-gray-900 hover:bg-gradient-to-r hover:from-white/80 hover:to-gray-50/80'
                }`}
              >
                <IconComponent className="w-5 h-5" />
                <span className="hidden sm:inline">{tab.label}</span>
                <span className="sm:hidden">{tab.key === 'nearby' ? 'Near' : tab.key === 'state' ? 'State' : 'All'}</span>
                <span className={`text-xs px-2 py-1 rounded-full ml-1 font-semibold ${
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
        <div className="p-6">
          <div className="flex flex-col lg:flex-row gap-4">
            {/* Search */}
          <div className="flex-1 relative">
            <MagnifyingGlassIcon className="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
            <input
              type="text"
                placeholder={`Search ${activeTab === 'nearby' ? 'nearby' : activeTab === 'state' ? 'Lagos state' : 'all'} medical centers...`}
              value={searchQuery}
                onChange={(e) => {
                  setSearchQuery(e.target.value);
                  setCurrentPage(1);
                  setLoadedItems(4);
                }}
                className="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
            />
          </div>
            
            {/* View Mode Toggle */}
            <div className="flex items-center bg-gray-100 rounded-lg p-1">
              <button
                onClick={() => setViewMode('grid')}
                className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                  viewMode === 'grid' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'
                }`}
              >
                Grid
              </button>
              <button
                onClick={() => setViewMode('list')}
                className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                  viewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'
                }`}
              >
                List
              </button>
            </div>

            {/* Filters Toggle */}
            <button
              onClick={() => setShowFilters(!showFilters)}
              className="flex items-center gap-2 px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
            >
              <FunnelIcon className="w-5 h-5" />
            Filters
              {Object.values(filters).some(filter => filter !== 'all' && filter !== false) && (
                <span className="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">
                  Active
                </span>
              )}
          </button>
        </div>

          {/* Advanced Filters - Toned Down */}
          {showFilters && (
            <div className="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
              <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">Facility Type</label>
                  <select
                    value={filters.type}
                    onChange={(e) => {
                      setFilters({ ...filters, type: e.target.value });
                      setCurrentPage(1);
                      setLoadedItems(4);
                    }}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                  >
                    <option value="all">All Types</option>
                    <option value="hospital">Hospital</option>
                    <option value="clinic">Clinic</option>
                    <option value="laboratory">Laboratory</option>
                    <option value="diagnostic_center">Diagnostic Center</option>
                  </select>
      </div>

                {/* Combined Rating and Price Column */}
                <div className="space-y-4">
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Minimum Rating</label>
                    <select
                      value={filters.rating}
                      onChange={(e) => {
                        setFilters({ ...filters, rating: e.target.value });
                        setCurrentPage(1);
                        setLoadedItems(4);
                      }}
                      className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                      <option value="all">Any Rating</option>
                      <option value="4.5">4.5+ Stars</option>
                      <option value="4.0">4.0+ Stars</option>
                      <option value="3.5">3.5+ Stars</option>
                    </select>
                  </div>
                  
                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                    <select
                      value={filters.priceRange}
                      onChange={(e) => {
                        setFilters({ ...filters, priceRange: e.target.value });
                        setCurrentPage(1);
                        setLoadedItems(4);
                      }}
                      className="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                      <option value="all">All Prices</option>
                      <option value="budget">Budget</option>
                      <option value="mid">Mid-range</option>
                      <option value="premium">Premium</option>
                    </select>
                  </div>
                </div>

                <div className="flex flex-col justify-center space-y-4">
                  <label className="flex items-center">
                    <input
                      type="checkbox"
                      checked={filters.openNow}
                      onChange={(e) => {
                        setFilters({ ...filters, openNow: e.target.checked });
                        setCurrentPage(1);
                        setLoadedItems(4);
                      }}
                      className="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    />
                    <span className="ml-2 text-sm text-gray-700">Open Now</span>
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
                      className="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    />
                    <span className="ml-2 text-sm text-gray-700">Verified Only</span>
                  </label>
                </div>

                <div className="flex items-end">
                  <button
                    onClick={resetFilters}
                    className="w-full px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                  >
                    <XMarkIcon className="w-4 h-4 inline mr-1" />
                    Clear All
                  </button>
                </div>
              </div>
            </div>
          )}
        </div>
      </div>

      {/* Results Info */}
      <div className="flex items-center justify-between mb-6">
        <div className="text-sm text-gray-600">
          {activeTab === 'nearby' || activeTab === 'state' ? (
            <>Showing {Math.min(loadedItems, filteredCenters.length)} of {filteredCenters.length} centers</>
          ) : (
            <>Showing {((currentPage - 1) * itemsPerPage) + 1}-{Math.min(currentPage * itemsPerPage, filteredCenters.length)} of {filteredCenters.length} centers</>
          )}
        </div>
        <div className="text-sm text-gray-500">
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
                <h3 className="text-xl font-semibold text-gray-900 mb-4 flex items-center gap-2">
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

          {/* Load More Button for Lazy Loading */}
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
                  className="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg"
                >
                  Load {Math.min(2, filteredCenters.length - loadedItems)} More Centers
                </button>
              )}
            </div>
          )}

          {/* This pagination was incorrectly placed - removed since we're using lazy loading for nearby/state tabs */}
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
      className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 cursor-pointer group"
              onClick={() => handleSelectCenter(center)}
            >
      {/* Header with name and verification */}
              <div className="flex items-start justify-between mb-4">
                <div className="flex-1">
                  <div className="flex items-center gap-2 mb-2">
            <h3 className="text-lg font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">
              {center.name}
            </h3>
                    {center.verified && (
                      <CheckCircleIcon className="w-5 h-5 text-green-500" />
                    )}
                  </div>
          <span className={`inline-block text-xs px-3 py-1 rounded-full font-medium ${
            center.priceRange === 'budget' ? 'bg-green-100 text-green-700' :
            center.priceRange === 'mid' ? 'bg-yellow-100 text-yellow-700' :
            'bg-blue-100 text-blue-700'
          }`}>
            {center.priceRange}
                    </span>
                  </div>
        
        {/* Rating */}
                <div className="text-right">
          <div className="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-lg">
                    <StarIcon className="w-4 h-4 text-yellow-400 fill-current" />
                    <span className="text-sm font-semibold">{center.rating}</span>
                    <span className="text-xs text-gray-500">({center.reviewCount})</span>
                  </div>
                </div>
              </div>

      {/* Location */}
      <div className="flex items-center text-gray-600 mb-3">
        <MapPinIcon className="w-4 h-4 mr-2 flex-shrink-0 text-blue-500" />
        <span className="text-sm flex-1">{center.address}</span>
        {activeTab === 'nearby' && (
          <span className="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
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
        <span className={`px-2 py-1 rounded-full text-xs font-medium ${
          center.openingHours.isOpen 
            ? 'bg-green-100 text-green-700' 
            : 'bg-red-100 text-red-700'
        }`}>
          {center.openingHours.isOpen ? 'Open' : 'Closed'}
        </span>
      </div>

      {/* Services */}
                <div className="flex flex-wrap gap-2 mb-4">
                  {center.services.slice(0, 3).map((service) => (
                    <span
                      key={service}
            className="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md"
                    >
                      {service}
                    </span>
                  ))}
                  {center.services.length > 3 && (
          <span className="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-md">
                      +{center.services.length - 3} more
                    </span>
                  )}
                </div>

      {/* Bottom section with phone and action */}
      <div className="border-t pt-4 mt-4">
                <div className="flex items-center justify-between">
          <div className="flex items-center text-gray-700">
            <PhoneIcon className="w-4 h-4 mr-2 text-green-600" />
            <span className="text-sm font-medium">{center.phone}</span>
                  </div>
          <ChevronRightIcon className="w-5 h-5 text-blue-600 group-hover:translate-x-1 transition-transform" />
                </div>
              </div>
            </div>
  );

  const renderCenterListItem = (center: MedicalCenter) => (
    <div
      key={center.id}
      className="bg-white rounded-lg shadow border border-gray-100 p-4 hover:shadow-md transition-all duration-200 cursor-pointer"
      onClick={() => handleSelectCenter(center)}
    >
      <div className="flex items-center justify-between">
        <div className="flex-1">
          <div className="flex items-center gap-3 mb-2">
            <h3 className="text-lg font-semibold text-gray-900">{center.name}</h3>
            {center.verified && <CheckCircleIcon className="w-4 h-4 text-green-500" />}
            <span className={`text-xs px-2 py-1 rounded-full ${
              center.priceRange === 'budget' ? 'bg-green-100 text-green-700' :
              center.priceRange === 'mid' ? 'bg-yellow-100 text-yellow-700' :
              'bg-blue-100 text-blue-700'
            }`}>
              {center.priceRange}
            </span>
            <span className={`text-xs px-2 py-1 rounded-full ${
              center.type === 'hospital' ? 'bg-red-100 text-red-700' :
              center.type === 'clinic' ? 'bg-blue-100 text-blue-700' :
              center.type === 'laboratory' ? 'bg-green-100 text-green-700' :
              'bg-purple-100 text-purple-700'
            }`}>
              {center.type.replace('_', ' ')}
            </span>
          </div>
          
          <div className="flex items-center gap-6 text-sm text-gray-600">
            <div className="flex items-center">
              <MapPinIcon className="w-4 h-4 mr-1" />
              {center.city}, {center.state}
              {activeTab === 'nearby' && (
                <span className="ml-2 text-blue-600 font-medium">{center.distance}</span>
              )}
            </div>
            <div className="flex items-center">
              <ClockIcon className="w-4 h-4 mr-1" />
              {center.openingHours.open} - {center.openingHours.close}
            </div>
            <div className="flex items-center">
              <StarIcon className="w-4 h-4 mr-1 text-yellow-400 fill-current" />
              {center.rating} ({center.reviewCount})
            </div>
          </div>
        </div>
        
        <div className="flex items-center space-x-3">
          <span className={`px-3 py-1 rounded-full text-sm font-medium ${
            center.openingHours.isOpen 
              ? 'bg-green-100 text-green-700' 
              : 'bg-red-100 text-red-700'
          }`}>
            {center.openingHours.isOpen ? 'Open' : 'Closed'}
          </span>
          <ChevronRightIcon className="w-5 h-5 text-blue-600" />
        </div>
      </div>
    </div>
  );

  const renderServicesStep = () => (
    <div className="animate-fade-in">
      <div className="flex items-center gap-4 mb-8">
        <button
          onClick={() => setStep('centers')}
          className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
        >
          <ArrowLeftIcon className="w-5 h-5" />
        </button>
        <div>
          <h1 className="text-3xl font-bold text-gray-900">{selectedCenter?.name}</h1>
          <p className="text-gray-600">Select a service category</p>
        </div>
      </div>

      <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <div className="flex items-center justify-between mb-4">
          <div>
            <h3 className="text-lg font-semibold text-gray-900 mb-1">Available Services</h3>
            <p className="text-sm text-gray-600">Choose the type of medical service you need</p>
          </div>
          <div>
            <h4 className="text-sm font-medium text-gray-700 mb-1">Center Rating</h4>
            <div className="flex items-center gap-2">
              <StarIcon className="w-5 h-5 text-yellow-400 fill-current" />
              <span className="font-semibold">{selectedCenter?.rating}</span>
              <span className="text-gray-500">({selectedCenter?.reviewCount} reviews)</span>
            </div>
          </div>
        </div>

        {/* Search and View Controls */}
        <div className="flex flex-col sm:flex-row gap-4">
          {/* Search */}
          <div className="flex-1 relative">
            <MagnifyingGlassIcon className="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
            <input
              type="text"
              placeholder="Search services..."
              value={serviceSearchQuery}
              onChange={(e) => setServiceSearchQuery(e.target.value)}
              className="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
            />
          </div>
          
          {/* View Mode Toggle */}
          <div className="flex items-center bg-gray-100 rounded-lg p-1">
            <button
              onClick={() => setServiceViewMode('grid')}
              className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                serviceViewMode === 'grid' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'
              }`}
            >
              Grid
            </button>
            <button
              onClick={() => setServiceViewMode('list')}
              className={`px-3 py-2 rounded-md text-sm font-medium transition-colors ${
                serviceViewMode === 'list' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600'
              }`}
            >
              List
            </button>
          </div>
        </div>

        {/* Results Info */}
        <div className="mt-4 text-sm text-gray-600">
          Showing {getFilteredServices().length} of {testCategories.length} services
        </div>
      </div>

      {serviceViewMode === 'grid' ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {getFilteredServices().map((category) => {
            const IconComponent = category.icon === 'BeakerIcon' ? BeakerIcon 
                                : category.icon === 'ShieldExclamationIcon' ? ShieldExclamationIcon
                                : category.icon === 'HeartIcon' ? HeartIcon
                                : ScaleIcon;
            
            return (
              <div
                key={category.id}
                className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-2xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 cursor-pointer group transform"
                onClick={() => handleSelectCategory(category)}
              >
                <div className="text-center">
                  <div className="flex justify-center mb-4">
                    <div className="p-3 bg-blue-50 rounded-full group-hover:bg-blue-100 group-hover:scale-110 transition-all duration-300">
                      <IconComponent className="w-8 h-8 text-blue-600 group-hover:text-blue-700" />
                    </div>
                  </div>
                  <h3 className="text-xl font-bold text-gray-900 mb-2 group-hover:text-blue-700 transition-colors">{category.name}</h3>
                  <p className="text-gray-600 text-sm mb-6">{category.description}</p>
                  <div className="space-y-2 mb-6">
                    <div className="flex items-center justify-between">
                      <span className="text-sm text-gray-500">Tests Available:</span>
                      <span className="text-blue-600 font-bold">{category.testCount} tests</span>
                    </div>
                    <div className="flex items-center justify-between">
                      <span className="text-sm text-gray-500">Price Range:</span>
                      <span className="text-gray-700 font-medium text-sm">{category.priceRange}</span>
                    </div>
                  </div>
                  <div className="flex items-center justify-center pt-2 border-t border-gray-100 group-hover:border-blue-200">
                    <span className="text-sm text-blue-600 font-medium mr-2 group-hover:text-blue-700">View Tests</span>
                    <ChevronRightIcon className="w-4 h-4 text-blue-600 group-hover:translate-x-1 group-hover:text-blue-700 transition-all duration-300" />
                  </div>
                </div>
              </div>
            );
          })}
        </div>
      ) : (
        <div className="space-y-4">
          {getFilteredServices().map((category) => {
            const IconComponent = category.icon === 'BeakerIcon' ? BeakerIcon 
                                : category.icon === 'ShieldExclamationIcon' ? ShieldExclamationIcon
                                : category.icon === 'HeartIcon' ? HeartIcon
                                : ScaleIcon;
            
            return (
              <div
                key={category.id}
                className="bg-white rounded-lg shadow border border-gray-100 p-4 hover:shadow-md transition-all duration-200 cursor-pointer"
                onClick={() => handleSelectCategory(category)}
              >
                <div className="flex items-center justify-between">
                  <div className="flex items-center space-x-4">
                    <div className="p-2 bg-blue-50 rounded-lg">
                      <IconComponent className="w-6 h-6 text-blue-600" />
                    </div>
                    <div className="flex-1">
                      <h3 className="text-lg font-semibold text-gray-900">{category.name}</h3>
                      <p className="text-gray-600 text-sm">{category.description}</p>
                      <div className="flex items-center space-x-4 mt-2 text-sm text-gray-500">
                        <span>{category.testCount} tests</span>
                        <span>•</span>
                        <span>{category.priceRange}</span>
                      </div>
                    </div>
                  </div>
                  <ChevronRightIcon className="w-5 h-5 text-blue-600" />
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
          className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
        >
          <ArrowLeftIcon className="w-5 h-5" />
        </button>
        <div>
          <h1 className="text-3xl font-bold text-gray-900">{selectedCategory?.name}</h1>
          <p className="text-gray-600">{selectedCategory?.description}</p>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2">
          <div className="space-y-4">
            {selectedCategory?.tests.map((test) => (
              <div
                key={test.id}
                className="bg-white rounded-xl shadow-lg border border-gray-100 p-6"
              >
                <div className="flex items-start justify-between mb-4">
                  <div className="flex-1">
                    <h3 className="text-xl font-semibold text-gray-900 mb-2">{test.name}</h3>
                    <p className="text-gray-600 text-sm mb-3">{test.description}</p>
                    
                    <div className="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                      <div>
                        <span className="font-medium text-gray-700">Preparation:</span>
                        <p className="text-gray-600">{test.preparationTime}</p>
                      </div>
                      <div>
                        <span className="font-medium text-gray-700">Results:</span>
                        <p className="text-gray-600">{test.resultTime}</p>
                      </div>
                      <div>
                        <span className="font-medium text-gray-700">Fasting:</span>
                        <p className="text-gray-600">{test.fasting ? 'Required' : 'Not required'}</p>
                      </div>
                    </div>
                  </div>
                  <div className="text-right ml-6">
                    <div className="text-2xl font-bold text-blue-600 mb-3">
                      ₦{test.price.toLocaleString()}
                    </div>
                    <div className="space-y-2">
                      <button
                        onClick={() => handleViewTestDetails(test)}
                        className="w-full px-4 py-2 rounded-lg border border-blue-600 text-blue-600 hover:bg-blue-50 transition-colors text-sm font-medium"
                      >
                        View Details
                      </button>
                      <button
                        onClick={() => handleAddToCart(test)}
                        disabled={cart.some(item => item.id === test.id)}
                        className={`w-full px-4 py-2 rounded-lg font-medium transition-colors ${
                          cart.some(item => item.id === test.id)
                            ? 'bg-green-100 text-green-700 cursor-not-allowed'
                            : 'bg-blue-600 text-white hover:bg-blue-700'
                        }`}
                      >
                        {cart.some(item => item.id === test.id) ? 'Added' : 'Add to Cart'}
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div className="lg:col-span-1">
          <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sticky top-6">
            <div className="flex items-center gap-2 mb-4">
              <ShoppingCartIcon className="w-5 h-5 text-blue-600" />
              <h3 className="text-lg font-semibold text-gray-900">Cart ({cart.length})</h3>
            </div>
            
            {cart.length === 0 ? (
              <p className="text-gray-500 text-center py-8">No tests selected</p>
            ) : (
              <>
                <div className="space-y-3 mb-6">
                  {cart.map((test) => (
                    <div key={test.id} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                      <div className="flex-1">
                        <h4 className="font-medium text-gray-900 text-sm">{test.name}</h4>
                        <p className="text-blue-600 font-semibold">₦{test.price.toLocaleString()}</p>
                      </div>
                      <button
                        onClick={() => handleRemoveFromCart(test.id)}
                        className="text-red-500 hover:text-red-700 p-1"
                      >
                        ×
                      </button>
                    </div>
                  ))}
                </div>
                
                <div className="border-t pt-4 mb-6">
                  <div className="flex items-center justify-between text-lg font-bold">
                    <span>Total:</span>
                    <span className="text-blue-600">₦{getTotalAmount().toLocaleString()}</span>
                  </div>
                </div>
                
                <button
                  onClick={() => setStep('cart')}
                  className="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium"
                >
                  Proceed to Checkout
                </button>
              </>
            )}
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
          className="p-2 hover:bg-gray-100 rounded-lg transition-colors"
        >
          <ArrowLeftIcon className="w-5 h-5" />
        </button>
        <div>
          <h1 className="text-3xl font-bold text-gray-900">Review Your Order</h1>
          <p className="text-gray-600">Confirm your tests and provide delivery details</p>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div className="lg:col-span-1">
          <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-6">Delivery Information</h3>
            
            <form className="space-y-6">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Delivery Address *
                </label>
                <textarea
                  value={deliveryDetails.address}
                  onChange={(e) => setDeliveryDetails({ ...deliveryDetails, address: e.target.value })}
                  rows={3}
                  className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Enter your full address..."
                  required
                />
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Phone Number *
                </label>
                <input
                  type="tel"
                  value={deliveryDetails.phone}
                  onChange={(e) => setDeliveryDetails({ ...deliveryDetails, phone: e.target.value })}
                  className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="+234 800 000 0000"
                  required
                />
              </div>
              
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Preferred Date *
                  </label>
                  <input
                    type="date"
                    value={deliveryDetails.preferredDate}
                    onChange={(e) => setDeliveryDetails({ ...deliveryDetails, preferredDate: e.target.value })}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                  />
                </div>
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Preferred Time *
                  </label>
                  <select
                    value={deliveryDetails.preferredTime}
                    onChange={(e) => setDeliveryDetails({ ...deliveryDetails, preferredTime: e.target.value })}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
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
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Additional Notes
                </label>
                <textarea
                  value={deliveryDetails.notes}
                  onChange={(e) => setDeliveryDetails({ ...deliveryDetails, notes: e.target.value })}
                  rows={3}
                  className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  placeholder="Any special instructions..."
                />
              </div>
            </form>
          </div>
        </div>

        <div className="lg:col-span-1">
          <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sticky top-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Order Total</h3>
            
            <div className="space-y-2 mb-4">
              <div className="flex justify-between">
                <span>Tests ({cart.length})</span>
                <span className="text-blue-600">₦{getTotalAmount().toLocaleString()}</span>
              </div>
              <div className="flex justify-between">
                <span>Home Collection</span>
                <span>₦2,000</span>
              </div>
              <div className="border-t pt-2">
                <div className="flex justify-between font-bold text-lg">
                  <span>Total</span>
                  <span className="text-blue-600">₦{(getTotalAmount() + 2000).toLocaleString()}</span>
                </div>
              </div>
            </div>
            
            <button
              onClick={handleSubmitOrder}
              disabled={!deliveryDetails.address || !deliveryDetails.phone || !deliveryDetails.preferredDate || !deliveryDetails.preferredTime}
              className="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition-colors font-medium disabled:bg-gray-300 disabled:cursor-not-allowed"
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
  );

  const renderTestModal = () => {
    if (!showTestModal || !selectedTestForModal) return null;

    return (
      <div className="fixed inset-0 bg-white/20 backdrop-blur-md flex items-center justify-center z-50 p-4">
        <div className="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
          <div className="bg-blue-600 text-white p-6 rounded-t-xl">
            <div className="flex items-center justify-between">
              <div>
                <h2 className="text-2xl font-bold">{selectedTestForModal.name}</h2>
                {selectedTestForModal.alternateName && (
                  <p className="text-blue-100 mt-1">Also known as: {selectedTestForModal.alternateName}</p>
                )}
              </div>
              <button
                onClick={handleCloseModal}
                className="text-white hover:text-gray-200 text-2xl font-bold"
              >
                ×
              </button>
            </div>
          </div>

          <div className="p-6">
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
              <div className="lg:col-span-2 space-y-6">
                <div className="bg-gray-50 rounded-lg p-4">
                  <h3 className="font-semibold text-gray-900 mb-2">Test Overview</h3>
                  <p className="text-gray-700">{selectedTestForModal.detailedDescription}</p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div className="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 className="font-medium text-gray-900 mb-2">Fasting Required</h4>
                    <p className="text-gray-700">{selectedTestForModal.fasting ? 'Yes' : 'No'}</p>
                  </div>
                  
                  <div className="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 className="font-medium text-gray-900 mb-2">Lab</h4>
                    <p className="text-gray-700">{selectedTestForModal.lab}</p>
                  </div>
                  
                  <div className="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 className="font-medium text-gray-900 mb-2">Specimen</h4>
                    <p className="text-gray-700">{selectedTestForModal.specimen}</p>
                  </div>
                  
                  <div className="bg-white border border-gray-200 rounded-lg p-4">
                    <h4 className="font-medium text-gray-900 mb-2">Results</h4>
                    <p className="text-gray-700">{selectedTestForModal.averageProcessingTime}</p>
                  </div>
                </div>

                <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                  <h4 className="font-medium text-yellow-800 mb-2">Special Instructions</h4>
                  <p className="text-yellow-700 text-sm">{selectedTestForModal.specialInstructions}</p>
                </div>

                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                  <h4 className="font-medium text-blue-800 mb-2">Collection Instructions</h4>
                  <p className="text-blue-700 text-sm">{selectedTestForModal.collectionInstructions}</p>
                </div>

                <div className="bg-gray-50 border border-gray-200 rounded-lg p-4">
                  <h4 className="font-medium text-gray-900 mb-2">Additional Information</h4>
                  <p className="text-gray-700 text-sm">{selectedTestForModal.additionalInformation}</p>
                </div>
              </div>

              <div className="lg:col-span-1">
                <div className="bg-white border border-gray-200 rounded-lg p-6 sticky top-6">
                  <div className="text-center mb-6">
                    <div className="text-3xl font-bold text-blue-600 mb-2">
                      ₦{selectedTestForModal.price.toLocaleString()}
                    </div>
                    <p className="text-gray-600 text-sm">Test Fee</p>
                  </div>

                  <div className="space-y-4 mb-6">
                    <div className="flex justify-between text-sm">
                      <span className="text-gray-600">Processing Time:</span>
                      <span className="font-medium">{selectedTestForModal.resultTime}</span>
                    </div>
                    <div className="flex justify-between text-sm">
                      <span className="text-gray-600">Preparation:</span>
                      <span className="font-medium text-right">{selectedTestForModal.preparationTime}</span>
                    </div>
                  </div>

                  <div className="space-y-3">
                    <button
                      onClick={() => {
                        handleAddToCart(selectedTestForModal);
                        handleCloseModal();
                      }}
                      disabled={cart.some(item => item.id === selectedTestForModal.id)}
                      className={`w-full py-3 px-4 rounded-lg font-medium transition-colors ${
                        cart.some(item => item.id === selectedTestForModal.id)
                          ? 'bg-green-100 text-green-700 cursor-not-allowed'
                          : 'bg-blue-600 text-white hover:bg-blue-700'
                      }`}
                    >
                      {cart.some(item => item.id === selectedTestForModal.id) ? 'Added to Cart' : 'Add to Cart'}
                    </button>
                    
                    <button
                      onClick={handleCloseModal}
                      className="w-full py-3 px-4 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-50 transition-colors"
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
      <div className="max-w-7xl mx-auto bg-gradient-to-br from-slate-50 via-blue-50 to-green-50 min-h-screen p-4 sm:p-6">
        <div className="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-6 sm:p-8 relative overflow-hidden">
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
      
      {/* Modal rendered outside main container */}
      {renderTestModal()}
    </>
  );
} 