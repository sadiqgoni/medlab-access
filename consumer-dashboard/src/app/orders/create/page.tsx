'use client';

import React, { useState, useEffect } from 'react';
import { useSearchParams, useRouter } from 'next/navigation';
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
  ScaleIcon
} from '@heroicons/react/24/outline';

interface MedicalCenter {
  id: string;
  name: string;
  address: string;
  distance: string;
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

const nearbyMedicalCenters: MedicalCenter[] = [
  {
    id: '1',
    name: 'Lagos Medical Center',
    address: '15 Ademola Street, Victoria Island, Lagos',
    distance: '1.2 km',
    rating: 4.8,
    reviewCount: 324,
    phone: '+234 1 234 5678',
    openingHours: { open: '7:00 AM', close: '9:00 PM', isOpen: true },
    services: ['Blood Tests', 'Radiology', 'Cardiology', 'General Health'],
    verified: true,
    image: '/images/lagos-medical.jpg'
  },
  {
    id: '2',
    name: 'HealthPlus Diagnostic',
    address: '23 Broad Street, Lagos Island, Lagos',
    distance: '2.8 km',
    rating: 4.6,
    reviewCount: 189,
    phone: '+234 1 345 6789',
    openingHours: { open: '6:00 AM', close: '10:00 PM', isOpen: true },
    services: ['Lab Tests', 'Pregnancy Tests', 'STD Screening'],
    verified: true,
    image: '/images/healthplus.jpg'
  },
  {
    id: '3',
    name: 'Iwosan Medical Laboratory',
    address: '45 Ikorodu Road, Palmgrove, Lagos',
    distance: '4.1 km',
    rating: 4.4,
    reviewCount: 156,
    phone: '+234 1 456 7890',
    openingHours: { open: '8:00 AM', close: '6:00 PM', isOpen: false },
    services: ['Blood Bank', 'Molecular Tests', 'Microbiology'],
    verified: true,
    image: '/images/iwosan-lab.jpg'
  },
  {
    id: '4',
    name: 'Clina-Lancet Laboratories',
    address: '12 Kofo Abayomi Street, Victoria Island, Lagos',
    distance: '1.8 km',
    rating: 4.9,
    reviewCount: 267,
    phone: '+234 1 567 8901',
    openingHours: { open: '24 Hours', close: '24 Hours', isOpen: true },
    services: ['Emergency Lab', 'Forensic Tests', 'Specialized Diagnostics'],
    verified: true,
    image: '/images/clina-lancet.jpg'
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
  const [selectedTests, setSelectedTests] = useState<Test[]>([]);
  const [cart, setCart] = useState<Test[]>([]);
  const [searchQuery, setSearchQuery] = useState('');
  const [showTestModal, setShowTestModal] = useState(false);
  const [selectedTestForModal, setSelectedTestForModal] = useState<Test | null>(null);
  const [deliveryDetails, setDeliveryDetails] = useState({
    address: '',
    phone: '',
    preferredDate: '',
    preferredTime: '',
    notes: ''
  });

  const handleSelectCenter = (center: MedicalCenter) => {
    setSelectedCenter(center);
    setStep('services');
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
    <div className="mb-8">
      <div className="flex items-center justify-center space-x-4">
        {[
          { key: 'centers', label: 'Centers', icon: '🏥' },
          { key: 'services', label: 'Services', icon: '📋' },
          { key: 'categories', label: 'Categories', icon: '🔬' },
          { key: 'tests', label: 'Tests', icon: '🧪' },
          { key: 'cart', label: 'Cart', icon: '🛒' }
        ].map((stepItem, index) => (
          <div key={stepItem.key} className="flex items-center">
            <div className={`w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold ${
              step === stepItem.key 
                ? 'bg-blue-600 text-white' 
                : index < ['centers', 'services', 'categories', 'tests', 'cart'].indexOf(step)
                  ? 'bg-green-500 text-white'
                  : 'bg-gray-200 text-gray-600'
            }`}>
              {stepItem.icon}
            </div>
            <span className="ml-2 text-sm font-medium text-gray-700 hidden sm:block">
              {stepItem.label}
            </span>
            {index < 4 && (
              <ChevronRightIcon className="w-4 h-4 text-gray-400 mx-2" />
            )}
          </div>
        ))}
      </div>
    </div>
  );

  const renderCentersStep = () => (
    <div className="animate-fade-in">
      <div className="text-center mb-8">
        <h1 className="text-3xl font-bold text-gray-900 mb-2">Select Medical Center</h1>
        <p className="text-gray-600">Choose from nearby verified medical facilities</p>
      </div>

      {/* Search and Filters */}
      <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
        <div className="flex flex-col sm:flex-row gap-4">
          <div className="flex-1 relative">
            <MagnifyingGlassIcon className="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400" />
            <input
              type="text"
              placeholder="Search medical centers..."
              value={searchQuery}
              onChange={(e) => setSearchQuery(e.target.value)}
              className="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            />
          </div>
          <button className="flex items-center gap-2 px-4 py-3 border border-gray-200 rounded-lg hover:bg-gray-50">
            <AdjustmentsHorizontalIcon className="w-5 h-5" />
            Filters
          </button>
        </div>
      </div>

      {/* Medical Centers Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {nearbyMedicalCenters
          .filter(center => 
            center.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
            center.address.toLowerCase().includes(searchQuery.toLowerCase())
          )
          .map((center) => (
            <div
              key={center.id}
              className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 cursor-pointer"
              onClick={() => handleSelectCenter(center)}
            >
              <div className="flex items-start justify-between mb-4">
                <div className="flex-1">
                  <div className="flex items-center gap-2 mb-2">
                    <h3 className="text-xl font-semibold text-gray-900">{center.name}</h3>
                    {center.verified && (
                      <CheckCircleIcon className="w-5 h-5 text-green-500" />
                    )}
                  </div>
                  <div className="flex items-center text-gray-600 mb-2">
                    <MapPinIcon className="w-4 h-4 mr-1" />
                    <span className="text-sm">{center.address}</span>
                  </div>
                  <div className="flex items-center text-gray-600 mb-2">
                    <ClockIcon className="w-4 h-4 mr-1" />
                    <span className="text-sm">
                      {center.openingHours.open} - {center.openingHours.close}
                    </span>
                    <span className={`ml-2 px-2 py-1 rounded-full text-xs font-medium ${
                      center.openingHours.isOpen 
                        ? 'bg-green-100 text-green-700' 
                        : 'bg-red-100 text-red-700'
                    }`}>
                      {center.openingHours.isOpen ? 'Open' : 'Closed'}
                    </span>
                  </div>
                </div>
                <div className="text-right">
                  <div className="flex items-center gap-1 mb-2">
                    <StarIcon className="w-4 h-4 text-yellow-400 fill-current" />
                    <span className="text-sm font-semibold">{center.rating}</span>
                    <span className="text-xs text-gray-500">({center.reviewCount})</span>
                  </div>
                  <div className="text-sm text-gray-600">{center.distance}</div>
                </div>
              </div>

              <div className="border-t pt-4">
                <div className="flex flex-wrap gap-2 mb-4">
                  {center.services.slice(0, 3).map((service) => (
                    <span
                      key={service}
                      className="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full"
                    >
                      {service}
                    </span>
                  ))}
                  {center.services.length > 3 && (
                    <span className="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full">
                      +{center.services.length - 3} more
                    </span>
                  )}
                </div>

                <div className="flex items-center justify-between">
                  <div className="flex items-center text-gray-600">
                    <PhoneIcon className="w-4 h-4 mr-1" />
                    <span className="text-sm">{center.phone}</span>
                  </div>
                  <ChevronRightIcon className="w-5 h-5 text-blue-600" />
                </div>
              </div>
            </div>
          ))}
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
        <div className="flex items-center justify-between">
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
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {testCategories.map((category) => {
          const IconComponent = category.icon === 'BeakerIcon' ? BeakerIcon 
                              : category.icon === 'ShieldExclamationIcon' ? ShieldExclamationIcon
                              : category.icon === 'HeartIcon' ? HeartIcon
                              : ScaleIcon;
          
          return (
            <div
              key={category.id}
              className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-200 cursor-pointer group"
              onClick={() => handleSelectCategory(category)}
            >
              <div className="text-center">
                <div className="flex justify-center mb-4">
                  <div className="p-3 bg-blue-50 rounded-full">
                    <IconComponent className="w-8 h-8 text-blue-600" />
                  </div>
                </div>
                <h3 className="text-xl font-bold text-gray-900 mb-2">{category.name}</h3>
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
                <div className="flex items-center justify-center pt-2 border-t border-gray-100">
                  <span className="text-sm text-blue-600 font-medium mr-2">View Tests</span>
                  <ChevronRightIcon className="w-4 h-4 text-blue-600 group-hover:translate-x-1 transition-transform" />
                </div>
              </div>
            </div>
          );
        })}
      </div>
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

        {/* Cart Sidebar */}
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
          <h1 className="text-3xl font-bold text-gray-900">Checkout</h1>
          <p className="text-gray-600">Review your order and delivery details</p>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div className="lg:col-span-2">
          {/* Order Summary */}
          <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
            <div className="space-y-3">
              {cart.map((test) => (
                <div key={test.id} className="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                  <div>
                    <h4 className="font-medium text-gray-900">{test.name}</h4>
                    <p className="text-sm text-gray-600">{selectedCenter?.name}</p>
                  </div>
                  <span className="font-semibold text-blue-600">₦{test.price.toLocaleString()}</span>
                </div>
              ))}
            </div>
          </div>

          {/* Delivery Details */}
          <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Delivery Details</h3>
            <form className="space-y-4">
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Delivery Address
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
              
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Phone Number
                  </label>
                  <input
                    type="tel"
                    value={deliveryDetails.phone}
                    onChange={(e) => setDeliveryDetails({ ...deliveryDetails, phone: e.target.value })}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="+234..."
                    required
                  />
                </div>
                
                <div>
                  <label className="block text-sm font-medium text-gray-700 mb-2">
                    Preferred Date
                  </label>
                  <input
                    type="date"
                    value={deliveryDetails.preferredDate}
                    onChange={(e) => setDeliveryDetails({ ...deliveryDetails, preferredDate: e.target.value })}
                    className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    min={new Date().toISOString().split('T')[0]}
                    required
                  />
                </div>
              </div>
              
              <div>
                <label className="block text-sm font-medium text-gray-700 mb-2">
                  Preferred Time
                </label>
                <select
                  value={deliveryDetails.preferredTime}
                  onChange={(e) => setDeliveryDetails({ ...deliveryDetails, preferredTime: e.target.value })}
                  className="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                  required
                >
                  <option value="">Select time...</option>
                  <option value="08:00">8:00 AM</option>
                  <option value="09:00">9:00 AM</option>
                  <option value="10:00">10:00 AM</option>
                  <option value="11:00">11:00 AM</option>
                  <option value="12:00">12:00 PM</option>
                  <option value="13:00">1:00 PM</option>
                  <option value="14:00">2:00 PM</option>
                  <option value="15:00">3:00 PM</option>
                  <option value="16:00">4:00 PM</option>
                  <option value="17:00">5:00 PM</option>
                </select>
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

        {/* Order Total */}
        <div className="lg:col-span-1">
          <div className="bg-white rounded-xl shadow-lg border border-gray-100 p-6 sticky top-6">
            <h3 className="text-lg font-semibold text-gray-900 mb-4">Order Total</h3>
            
            <div className="space-y-2 mb-4">
              <div className="flex justify-between">
                <span>Tests ({cart.length})</span>
                <span>₦{getTotalAmount().toLocaleString()}</span>
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
      <div className="fixed inset-0 bg-white bg-opacity-10 backdrop-blur-md flex items-center justify-center z-50 p-4" style={{backgroundColor: 'rgba(0, 0, 0, 0.1)'}}>
        <div className="bg-white rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
          {/* Modal Header */}
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

          {/* Modal Content */}
          <div className="p-6">
            <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
              {/* Left Column - Details */}
              <div className="lg:col-span-2 space-y-6">
                {/* Test Overview */}
                <div className="bg-gray-50 rounded-lg p-4">
                  <h3 className="font-semibold text-gray-900 mb-2">Test Overview</h3>
                  <p className="text-gray-700">{selectedTestForModal.detailedDescription}</p>
                </div>

                {/* Test Information Grid */}
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

                {/* Special Instructions */}
                <div className="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                  <h4 className="font-medium text-yellow-800 mb-2">Special Instructions</h4>
                  <p className="text-yellow-700 text-sm">{selectedTestForModal.specialInstructions}</p>
                </div>

                {/* Collection Instructions */}
                <div className="bg-blue-50 border border-blue-200 rounded-lg p-4">
                  <h4 className="font-medium text-blue-800 mb-2">Collection Instructions</h4>
                  <p className="text-blue-700 text-sm">{selectedTestForModal.collectionInstructions}</p>
                </div>

                {/* Additional Information */}
                <div className="bg-gray-50 border border-gray-200 rounded-lg p-4">
                  <h4 className="font-medium text-gray-900 mb-2">Additional Information</h4>
                  <p className="text-gray-700 text-sm">{selectedTestForModal.additionalInformation}</p>
                </div>
              </div>

              {/* Right Column - Pricing & Actions */}
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
    <div className="max-w-7xl mx-auto">
      {renderStepIndicator()}
      
      {step === 'centers' && renderCentersStep()}
      {step === 'services' && renderServicesStep()}
      {step === 'tests' && renderTestsStep()}
      {step === 'cart' && renderCartStep()}
      
      {renderTestModal()}
    </div>
  );
} 