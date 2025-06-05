'use client';

import React, { useState } from 'react';
import Link from 'next/link';
import { 
  MagnifyingGlassIcon,
  FunnelIcon,
  BeakerIcon,
  HeartIcon,
  CpuChipIcon,
  ShieldCheckIcon,
  EyeIcon,
  UserIcon,
} from '@heroicons/react/24/outline';

interface TestCategory {
  id: string;
  name: string;
  description: string;
  icon: React.ComponentType<any>;
  testCount: number;
  popularTests: string[];
  color: string;
}

const testCategories: TestCategory[] = [
  {
    id: 'blood-tests',
    name: 'Blood Tests',
    description: 'Complete blood analysis, glucose, cholesterol, and more',
    icon: BeakerIcon,
    testCount: 45,
    popularTests: ['Full Blood Count', 'Blood Glucose', 'Lipid Profile'],
    color: 'bg-red-50 border-red-200 text-red-700'
  },
  {
    id: 'allergy-tests',
    name: 'Allergy Panel',
    description: 'Food allergies, environmental, and seasonal allergies',
    icon: ShieldCheckIcon,
    testCount: 28,
    popularTests: ['Basic Food Allergy Panel', 'Environmental Allergies', 'Drug Allergy Test'],
    color: 'bg-orange-50 border-orange-200 text-orange-700'
  },
  {
    id: 'heart-health',
    name: 'Heart Health',
    description: 'Cardiovascular screening and heart disease prevention',
    icon: HeartIcon,
    testCount: 18,
    popularTests: ['ECG', 'Cardiac Enzymes', 'Blood Pressure Monitoring'],
    color: 'bg-pink-50 border-pink-200 text-pink-700'
  },
  {
    id: 'infectious-diseases',
    name: 'Infectious Diseases',
    description: 'HIV, Hepatitis, Malaria, Tuberculosis screening',
    icon: CpuChipIcon,
    testCount: 32,
    popularTests: ['HIV Test', 'Hepatitis B & C', 'Malaria Test', 'TB Test'],
    color: 'bg-purple-50 border-purple-200 text-purple-700'
  },
  {
    id: 'womens-health',
    name: "Women's Health",
    description: 'Pregnancy, hormonal, and reproductive health tests',
    icon: UserIcon,
    testCount: 24,
    popularTests: ['Pregnancy Test', 'Pap Smear', 'Hormonal Panel'],
    color: 'bg-green-50 border-green-200 text-green-700'
  },
  {
    id: 'vision-hearing',
    name: 'Vision & Hearing',
    description: 'Eye exams, hearing tests, and sensory health',
    icon: EyeIcon,
    testCount: 12,
    popularTests: ['Eye Exam', 'Hearing Test', 'Glaucoma Screening'],
    color: 'bg-blue-50 border-blue-200 text-blue-700'
  },
];

export default function TestsPage() {
  const [searchQuery, setSearchQuery] = useState('');
  const [selectedFilter, setSelectedFilter] = useState('all');

  const filteredCategories = testCategories.filter(category =>
    category.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
    category.description.toLowerCase().includes(searchQuery.toLowerCase()) ||
    category.popularTests.some(test => test.toLowerCase().includes(searchQuery.toLowerCase()))
  );

  return (
    <div className="space-y-6">
      {/* Header */}
      <div className="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-6 sm:p-8">
        <div className="max-w-3xl">
          <h1 className="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
            Medical Tests & Diagnostics
          </h1>
          <p className="text-gray-600 text-sm sm:text-base">
            Comprehensive health testing across Nigeria. Choose from our wide range of medical tests 
            performed at certified laboratories nationwide.
          </p>
        </div>
      </div>

      {/* Search and Filters */}
      <div className="flex flex-col sm:flex-row gap-4">
        <div className="flex-1 relative">
          <MagnifyingGlassIcon className="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" />
          <input
            type="text"
            placeholder="Search tests, conditions, or symptoms..."
            className="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
          />
        </div>
        <div className="flex gap-2">
          <button className="flex items-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
            <FunnelIcon className="h-5 w-5 mr-2 text-gray-500" />
            <span className="text-sm font-medium">Filters</span>
          </button>
        </div>
      </div>

      {/* Popular Searches */}
      <div className="flex flex-wrap gap-2">
        <span className="text-sm text-gray-600">Popular:</span>
        {['Blood Test', 'Malaria', 'HIV Test', 'Pregnancy', 'Diabetes'].map((term) => (
          <button
            key={term}
            onClick={() => setSearchQuery(term)}
            className="px-3 py-1 bg-gray-100 rounded-full text-xs text-gray-700 hover:bg-gray-200 transition-colors"
          >
            {term}
          </button>
        ))}
      </div>

      {/* Categories Grid */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        {filteredCategories.map((category) => (
          <Link
            key={category.id}
            href={`/tests/${category.id}`}
            className="group block"
          >
            <div className={`h-full p-6 rounded-xl border-2 border-dashed transition-all duration-200 hover:border-solid hover:shadow-lg hover:-translate-y-1 ${category.color}`}>
              <div className="flex items-start justify-between mb-4">
                <div className="h-12 w-12 rounded-lg bg-white/70 flex items-center justify-center group-hover:scale-110 transition-transform">
                  <category.icon className="h-6 w-6" />
                </div>
                <span className="text-xs font-medium px-2 py-1 bg-white/70 rounded-full">
                  {category.testCount} tests
                </span>
              </div>
              
              <h3 className="text-lg font-semibold mb-2 group-hover:text-gray-900 transition-colors">
                {category.name}
              </h3>
              
              <p className="text-sm opacity-80 mb-4 line-clamp-2">
                {category.description}
              </p>
              
              <div className="space-y-1">
                <p className="text-xs font-medium opacity-70">Popular tests:</p>
                <div className="flex flex-wrap gap-1">
                  {category.popularTests.slice(0, 2).map((test, index) => (
                    <span key={index} className="text-xs px-2 py-1 bg-white/50 rounded-md">
                      {test}
                    </span>
                  ))}
                  {category.popularTests.length > 2 && (
                    <span className="text-xs px-2 py-1 bg-white/50 rounded-md">
                      +{category.popularTests.length - 2} more
                    </span>
                  )}
                </div>
              </div>
            </div>
          </Link>
        ))}
      </div>

      {/* Nigerian Medical Context */}
      <div className="bg-gradient-to-r from-green-50 to-blue-50 rounded-xl p-6">
        <h2 className="text-lg font-semibold text-gray-900 mb-3">🇳🇬 Healthcare Excellence Across Nigeria</h2>
        <div className="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
          <div className="flex items-center space-x-2">
            <div className="h-2 w-2 rounded-full bg-green-500"></div>
            <span>Over 200+ certified labs nationwide</span>
          </div>
          <div className="flex items-center space-x-2">
            <div className="h-2 w-2 rounded-full bg-blue-500"></div>
            <span>Results in 24-72 hours</span>
          </div>
          <div className="flex items-center space-x-2">
            <div className="h-2 w-2 rounded-full bg-purple-500"></div>
            <span>Insurance accepted</span>
          </div>
        </div>
      </div>

      {/* Emergency Notice */}
      <div className="bg-red-50 border border-red-200 rounded-lg p-4">
        <div className="flex items-start">
          <div className="flex-shrink-0">
            <div className="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center">
              <span className="text-red-600 text-sm">!</span>
            </div>
          </div>
          <div className="ml-3">
            <h3 className="text-sm font-medium text-red-800">
              Need Emergency Testing?
            </h3>
            <div className="mt-1 text-sm text-red-700">
              <p>For urgent medical situations, call <strong>112</strong> or visit the nearest emergency room. 
              Our platform offers routine and preventive testing services.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
} 